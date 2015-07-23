<?php




class remoteDb
{

    protected static $_instance;

    protected static $_prefix;

    protected $_mysqli;

    protected $_query;

    protected $_lastQuery;

    protected $_join = array(); 

    protected $_where = array();

    protected $_orderBy = array(); 

    protected $_groupBy = array(); 

    protected $_bindParams = array('');

    public $count = 0;

    public $totalCount = 0;

    protected $fetchTotalCount = false;

    protected $_stmtError;


    protected $host;

    protected $username;

    protected $password;

    protected $db;

    protected $port;

    protected $charset;

    protected $isSubQuery = false;


    public function __construct()
    {

        $dbconfig =include 'dbconfig.php';
        $host = $dbconfig['host'];
        $username = $dbconfig['username'];
        $password = $dbconfig['password'];
        $db = $dbconfig['db'];
        $port = NULL;
        $charset = $dbconfig['charset'];
        $isSubQuery = false;

        // if params were passed as array
        if (is_array ($host)) {
            foreach ($host as $key => $val)
                $$key = $val;
        }
        // if host were set as mysqli socket
        if (is_object ($host))
            $this->_mysqli = $host;
        else
            $this->host = $host;

        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        $this->port = $port;
        $this->charset = $charset;

        if ($isSubQuery) {
            $this->isSubQuery = true;
            return;
        }


        if (!is_object ($host))
            $this->connect();

        $this->setPrefix();
        self::$_instance = $this;
    }


    public function connect()
    {
        if ($this->isSubQuery)
            return;

        if (empty ($this->host))
            die ('Mysql host is not set');

        $this->_mysqli = new mysqli ($this->host, $this->username, $this->password, $this->db, $this->port)
            or die('There was a problem connecting to the database');

        if ($this->charset)
            $this->_mysqli->set_charset ($this->charset);
    }

    public static function getInstance()
    {
        return self::$_instance;
    }


    protected function reset()
    {
        $this->_where = array();
        $this->_join = array();
        $this->_orderBy = array();
        $this->_groupBy = array(); 
        $this->_bindParams = array(''); // Create the empty 0 index
        $this->_query = null;
        $this->count = 0;
    }
    

    public function setPrefix($prefix = '')
    {
        self::$_prefix = $prefix;
        return $this;
    }


    public function rawQuery ($query, $bindParams = null, $sanitize = true)
    {
        $params = array(''); // Create the empty 0 index
        $this->_query = $query;
        if ($sanitize)
            $this->_query = filter_var ($query, FILTER_SANITIZE_STRING,
                                    FILTER_FLAG_NO_ENCODE_QUOTES);
        $stmt = $this->_prepareQuery();

        if (is_array($bindParams) === true) {
            foreach ($bindParams as $prop => $val) {
                $params[0] .= $this->_determineType($val);
                array_push($params, $bindParams[$prop]);
            }

            call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));

        }

        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->_lastQuery = $this->replacePlaceHolders ($this->_query, $params);
        $this->reset();

        return $this->_dynamicBindResults($stmt);
    }


    public function query($query, $numRows = null)
    {
        $this->_query = filter_var($query, FILTER_SANITIZE_STRING);
        $stmt = $this->_buildQuery($numRows);
        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();

        return $this->_dynamicBindResults($stmt);
    }


    public function withTotalCount () {
        $this->fetchTotalCount = true;
        return $this;
    }


    public function get($tableName, $numRows = null, $columns = '*')
    {
        if (empty ($columns))
            $columns = '*';

        $this->_query = $this->fetchTotalCount == true ? 'SELECT SQL_CALC_FOUND_ROWS ' : 'SELECT '; 
        $column = is_array($columns) ? implode(', ', $columns) : $columns; 
        $this->_query .= "$column FROM " .self::$_prefix . $tableName;
        $stmt = $this->_buildQuery($numRows);

        if ($this->isSubQuery)
            return $this;

        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();

        return $this->_dynamicBindResults($stmt);
    }


    public function getOne($tableName, $columns = '*') 
    {
        $res = $this->get ($tableName, 1, $columns);

        if (is_object($res))
            return $res;

        if (isset($res[0]))
            return $res[0];

        return null;
    }


    public function getValue($tableName, $column) 
    {
        $res = $this->get ($tableName, 1, "{$column} as retval");

        if (isset($res[0]["retval"]))
            return $res[0]["retval"];

        return null;
    }


    public function insert($tableName, $insertData)
    {
        if ($this->isSubQuery)
            return;

        $this->_query = "INSERT INTO " .self::$_prefix . $tableName;
        $stmt = $this->_buildQuery(null, $insertData);
        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();
        $this->count = $stmt->affected_rows;

        if ($stmt->affected_rows < 1)
            return false;

        if ($stmt->insert_id > 0)
            return $stmt->insert_id;

        return true;
    }


    public function has($tableName)
    {
        $this->getOne($tableName, '1');
        return $this->count >= 1;
    }


    public function update($tableName, $tableData)
    {
        if ($this->isSubQuery)
            return;

        $this->_query = "UPDATE " . self::$_prefix . $tableName;

        $stmt = $this->_buildQuery (null, $tableData);
        $status = $stmt->execute();
        $this->reset();
        $this->_stmtError = $stmt->error;
        $this->count = $stmt->affected_rows;

        return $status;
    }


    public function delete($tableName, $numRows = null)
    {
        if ($this->isSubQuery)
            return;

        $this->_query = "DELETE FROM " . self::$_prefix . $tableName;

        $stmt = $this->_buildQuery($numRows);
        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();

        return ($stmt->affected_rows > 0);
    }


    public function where($whereProp, $whereValue = null, $operator = null)
    {
        if ($operator)
            $whereValue = Array ($operator => $whereValue);

        $this->_where[] = Array ("AND", $whereValue, $whereProp);
        return $this;
    }


    public function orWhere($whereProp, $whereValue = null, $operator = null)
    {
        if ($operator)
            $whereValue = Array ($operator => $whereValue);

        $this->_where[] = Array ("OR", $whereValue, $whereProp);
        return $this;
    }

     public function join($joinTable, $joinCondition, $joinType = '')
     {
        $allowedTypes = array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER');
        $joinType = strtoupper (trim ($joinType));

        if ($joinType && !in_array ($joinType, $allowedTypes))
            die ('Wrong JOIN type: '.$joinType);

        if (!is_object ($joinTable))
            $joinTable = self::$_prefix . filter_var($joinTable, FILTER_SANITIZE_STRING);

        $this->_join[] = Array ($joinType,  $joinTable, $joinCondition);

        return $this;
    }

    public function orderBy($orderByField, $orderbyDirection = "DESC", $customFields = null)
    {
        $allowedDirection = Array ("ASC", "DESC");
        $orderbyDirection = strtoupper (trim ($orderbyDirection));
        $orderByField = preg_replace ("/[^-a-z0-9\.\(\),_`]+/i",'', $orderByField);

        if (empty($orderbyDirection) || !in_array ($orderbyDirection, $allowedDirection))
            die ('Wrong order direction: '.$orderbyDirection);

        if (is_array ($customFields)) {
            foreach ($customFields as $key => $value)
                $customFields[$key] = preg_replace ("/[^-a-z0-9\.\(\),_`]+/i",'', $value);

            $orderByField = 'FIELD (' . $orderByField . ', "' . implode('","', $customFields) . '")';
        }

        $this->_orderBy[$orderByField] = $orderbyDirection;
        return $this;
    } 


    public function groupBy($groupByField)
    {
        $groupByField = preg_replace ("/[^-a-z0-9\.\(\),_]+/i",'', $groupByField);

        $this->_groupBy[] = $groupByField;
        return $this;
    } 


    public function getInsertId()
    {
        return $this->_mysqli->insert_id;
    }


    public function escape($str)
    {
        return $this->_mysqli->real_escape_string($str);
    }


    public function ping() {
        return $this->_mysqli->ping();
    }


    protected function _determineType($item)
    {
        switch (gettype($item)) {
            case 'NULL':
            case 'string':
                return 's';
                break;

            case 'boolean':
            case 'integer':
                return 'i';
                break;

            case 'blob':
                return 'b';
                break;

            case 'double':
                return 'd';
                break;
        }
        return '';
    }


    protected function _bindParam($value) {
        $this->_bindParams[0] .= $this->_determineType ($value);
        array_push ($this->_bindParams, $value);
    }


    protected function _bindParams ($values) {
        foreach ($values as $value)
            $this->_bindParam ($value);
    }


    protected function _buildPair ($operator, $value) {
        if (!is_object($value)) {
            $this->_bindParam ($value);
            return ' ' . $operator. ' ? ';
        }

        $subQuery = $value->getSubQuery ();
        $this->_bindParams ($subQuery['params']);

        return " " . $operator . " (" . $subQuery['query'] . ") " . $subQuery['alias'];
    }


    protected function _buildQuery($numRows = null, $tableData = null)
    {
        $this->_buildJoin();
        $this->_buildTableData ($tableData);
        $this->_buildWhere();
        $this->_buildGroupBy();
        $this->_buildOrderBy();
        $this->_buildLimit ($numRows);

        $this->_lastQuery = $this->replacePlaceHolders ($this->_query, $this->_bindParams);

        if ($this->isSubQuery)
            return;

        // Prepare query
        $stmt = $this->_prepareQuery();

        // Bind parameters to statement if any
        if (count ($this->_bindParams) > 1)
            call_user_func_array(array($stmt, 'bind_param'), $this->refValues($this->_bindParams));

        return $stmt;
    }


    protected function _dynamicBindResults(mysqli_stmt $stmt)
    {
        $parameters = array();
        $results = array();

        $meta = $stmt->result_metadata();


        if(!$meta && $stmt->sqlstate) { 
            return array();
        }

        $row = array();
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
            $parameters[] = & $row[$field->name];
        }


        if (version_compare (phpversion(), '5.4', '<'))
             $stmt->store_result();

        call_user_func_array(array($stmt, 'bind_result'), $parameters);

        $this->totalCount = 0;
        $this->count = 0;
        while ($stmt->fetch()) {
            $x = array();
            foreach ($row as $key => $val) {
                $x[$key] = $val;
            }
            $this->count++;
            array_push($results, $x);
        }

        if ($this->_mysqli->more_results())
            $this->_mysqli->next_result();

        if ($this->fetchTotalCount === true) {
            $this->fetchTotalCount = false;
            $stmt = $this->_mysqli->query ('SELECT FOUND_ROWS();');
            $totalCount = $stmt->fetch_row();
            $this->totalCount = $totalCount[0];
        }

        return $results;
    }



    protected function _buildJoin () {
        if (empty ($this->_join))
            return;

        foreach ($this->_join as $data) {
            list ($joinType,  $joinTable, $joinCondition) = $data;

            if (is_object ($joinTable))
                $joinStr = $this->_buildPair ("", $joinTable);
            else
                $joinStr = $joinTable;

            $this->_query .= " " . $joinType. " JOIN " . $joinStr ." on " . $joinCondition;
        }
    }


    protected function _buildTableData ($tableData) {
        if (!is_array ($tableData))
            return;

        $isInsert = strpos ($this->_query, 'INSERT');
        $isUpdate = strpos ($this->_query, 'UPDATE');

        if ($isInsert !== false) {
            $this->_query .= ' (`' . implode(array_keys($tableData), '`, `') . '`)';
            $this->_query .= ' VALUES (';
        } else
            $this->_query .= " SET ";

        foreach ($tableData as $column => $value) {
            if ($isUpdate !== false)
                $this->_query .= "`" . $column . "` = ";


            if (is_object ($value)) {
                $this->_query .= $this->_buildPair ("", $value) . ", ";
                continue;
            }


            if (!is_array ($value)) {
                $this->_bindParam ($value);
                $this->_query .= '?, ';
                continue;
            }


            $key = key ($value);
            $val = $value[$key];
            switch ($key) {
                case '[I]':
                    $this->_query .= $column . $val . ", ";
                    break;
                case '[F]':
                    $this->_query .= $val[0] . ", ";
                    if (!empty ($val[1]))
                        $this->_bindParams ($val[1]);
                    break;
                case '[N]':
                    if ($val == null)
                        $this->_query .= "!" . $column . ", ";
                    else
                        $this->_query .= "!" . $val . ", ";
                    break;
                default:
                    die ("Wrong operation");
            }
        }
        $this->_query = rtrim($this->_query, ', ');
        if ($isInsert !== false)
            $this->_query .= ')';
    }


    protected function _buildWhere () {
        if (empty ($this->_where))
            return;


        $this->_query .= ' WHERE';


        $this->_where[0][0] = '';
        foreach ($this->_where as $cond) {
            list ($concat, $wValue, $wKey) = $cond;

            $this->_query .= " " . $concat ." " . $wKey;


            if ($wValue === null)
                continue;


            if (!is_array ($wValue))
                $wValue = Array ('=' => $wValue);

            $key = key ($wValue);
            $val = $wValue[$key];
            switch (strtolower ($key)) {
                case '0':
                    $this->_bindParams ($wValue);
                    break;
                case 'not in':
                case 'in':
                    $comparison = ' ' . $key . ' (';
                    if (is_object ($val)) {
                        $comparison .= $this->_buildPair ("", $val);
                    } else {
                        foreach ($val as $v) {
                            $comparison .= ' ?,';
                            $this->_bindParam ($v);
                        }
                    }
                    $this->_query .= rtrim($comparison, ',').' ) ';
                    break;
                case 'not between':
                case 'between':
                    $this->_query .= " $key ? AND ? ";
                    $this->_bindParams ($val);
                    break;
                case 'not exists':
                case 'exists':
                    $this->_query.= $key . $this->_buildPair ("", $val);
                    break;
                default:
                    $this->_query .= $this->_buildPair ($key, $val);
            }
        }
    }


    protected function _buildGroupBy () {
        if (empty ($this->_groupBy))
            return;

        $this->_query .= " GROUP BY ";
        foreach ($this->_groupBy as $key => $value)
            $this->_query .= $value . ", ";

        $this->_query = rtrim($this->_query, ', ') . " ";
    }


    protected function _buildOrderBy () {
        if (empty ($this->_orderBy))
            return;

        $this->_query .= " ORDER BY ";
        foreach ($this->_orderBy as $prop => $value) {
            if (strtolower (str_replace (" ", "", $prop)) == 'rand()')
                $this->_query .= "rand(), ";
            else
                $this->_query .= $prop . " " . $value . ", ";
        }

        $this->_query = rtrim ($this->_query, ', ') . " ";
    }


    protected function _buildLimit ($numRows) {
        if (!isset ($numRows))
            return;

        if (is_array ($numRows))
            $this->_query .= ' LIMIT ' . (int)$numRows[0] . ', ' . (int)$numRows[1];
        else
            $this->_query .= ' LIMIT ' . (int)$numRows;
    }


    protected function _prepareQuery()
    {
        if (!$stmt = $this->_mysqli->prepare($this->_query)) {
            trigger_error("Problem preparing query ($this->_query) " . $this->_mysqli->error, E_USER_ERROR);
        }
        return $stmt;
    }


    public function __destruct()
    {
        if (!$this->isSubQuery)
            return;
        if ($this->_mysqli)
            $this->_mysqli->close();
    }


    protected function refValues($arr)
    {
        //Reference is required for PHP 5.3+
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = array();
            foreach ($arr as $key => $value) {
                $refs[$key] = & $arr[$key];
            }
            return $refs;
        }
        return $arr;
    }


    protected function replacePlaceHolders ($str, $vals) {
        $i = 1;
        $newStr = "";

        while ($pos = strpos ($str, "?")) {
            $val = $vals[$i++];
            if (is_object ($val))
                $val = '[object]';
            if ($val == NULL)
                $val = 'NULL';
            $newStr .= substr ($str, 0, $pos) . "'". $val . "'";
            $str = substr ($str, $pos + 1);
        }
        $newStr .= $str;
        return $newStr;
    }


    public function getLastQuery () {
        return $this->_lastQuery;
    }

    public function getLastError () {
        return trim ($this->_stmtError . " " . $this->_mysqli->error);
    }


    public function getSubQuery () {
        if (!$this->isSubQuery)
            return null;

        array_shift ($this->_bindParams);
        $val = Array ('query' => $this->_query,
                      'params' => $this->_bindParams,
                      'alias' => $this->host
                );
        $this->reset();
        return $val;
    }


    public function interval ($diff, $func = "NOW()") {
        $types = Array ("s" => "second", "m" => "minute", "h" => "hour", "d" => "day", "M" => "month", "Y" => "year");
        $incr = '+';
        $items = '';
        $type = 'd';

        if ($diff && preg_match('/([+-]?) ?([0-9]+) ?([a-zA-Z]?)/',$diff, $matches)) {
            if (!empty ($matches[1])) $incr = $matches[1];
            if (!empty ($matches[2])) $items = $matches[2];
            if (!empty ($matches[3])) $type = $matches[3];
            if (!in_array($type, array_keys($types)))
                trigger_error ("invalid interval type in '{$diff}'");
            $func .= " ".$incr ." interval ". $items ." ".$types[$type] . " ";
        }
        return $func;

    }

    public function now ($diff = null, $func = "NOW()") {
        return Array ("[F]" => Array($this->interval($diff, $func)));
    }


    public function inc($num = 1) {
        return Array ("[I]" => "+" . (int)$num);
    }


    public function dec ($num = 1) {
        return Array ("[I]" => "-" . (int)$num);
    }
    

    public function not ($col = null) {
        return Array ("[N]" => (string)$col);
    }


    public function func ($expr, $bindParams = null) {
        return Array ("[F]" => Array($expr, $bindParams));
    }


    public static function subQuery($subQueryAlias = "")
    {
        return new MysqliDb (Array('host' => $subQueryAlias, 'isSubQuery' => true));
    }


    public function copy ()
    {
        $copy = unserialize (serialize ($this));
        $copy->_mysqli = $this->_mysqli;
        return $copy;
    }


    public function startTransaction () {
        $this->_mysqli->autocommit (false);
        $this->_transaction_in_progress = true;
        register_shutdown_function (array ($this, "_transaction_status_check"));
    }


    public function commit () {
        $this->_mysqli->commit ();
        $this->_transaction_in_progress = false;
        $this->_mysqli->autocommit (true);
    }


    public function rollback () {
      $this->_mysqli->rollback ();
      $this->_transaction_in_progress = false;
      $this->_mysqli->autocommit (true);
    }


    public function _transaction_status_check () {
        if (!$this->_transaction_in_progress)
            return;
        $this->rollback ();
    }
}


