<?php

class CustomSessionHandler implements SessionHandlerInterface
{
    private $db;

    public function getDB(){
        if(!isset($GLOBALS["db"])){
            $GLOBALS["db"] = new SQLite3("ds.db");
        }
        return $GLOBALS["db"];
    }


    /**
     * Close the session
     * @link https://php.net/manual/en/sessionhandlerinterface.close.php
     * @return bool <p>
     * The return value (usually TRUE on success, FALSE on failure).
     * Note this value is returned internally to PHP for processing.
     * </p>
     * @since 5.4.0
     */
    public function close()
    {
        return true;
    }

    /**
     * Destroy a session
     * @link https://php.net/manual/en/sessionhandlerinterface.destroy.php
     * @param string $session_id The session ID being destroyed.
     * @return bool <p>
     * The return value (usually TRUE on success, FALSE on failure).
     * Note this value is returned internally to PHP for processing.
     * </p>
     * @since 5.4.0
     */
    public function destroy($session_id)
    {
        $query = "DELETE FROM sessions WHERE id=$session_id";
        if( $this->getDB()->query($query) ){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Cleanup old sessions
     * @link https://php.net/manual/en/sessionhandlerinterface.gc.php
     * @param int $maxlifetime <p>
     * Sessions that have not updated for
     * the last maxlifetime seconds will be removed.
     * </p>
     * @return bool <p>
     * The return value (usually TRUE on success, FALSE on failure).
     * Note this value is returned internally to PHP for processing.
     * </p>
     * @since 5.4.0
     */
    public function gc($maxlifetime)
    {
        $access = time();
        $mintime = strtotime($access) - strtotime($maxlifetime);
        $query = "DELETE FROM sessions WHERE timestamp < $mintime";

        if($this->getDB()->query($query)){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Initialize session
     * @link https://php.net/manual/en/sessionhandlerinterface.open.php
     * @param string $save_path The path where to store/retrieve the session.
     * @param string $name The session name.
     * @return bool <p>
     * The return value (usually TRUE on success, FALSE on failure).
     * Note this value is returned internally to PHP for processing.
     * </p>
     * @since 5.4.0
     */
    public function open($save_path, $name)
    {
        return true;
    }

    /**
     * Read session data
     * @link https://php.net/manual/en/sessionhandlerinterface.read.php
     * @param string $session_id The session id to read data for.
     * @return string <p>
     * Returns an encoded string of the read data.
     * If nothing was read, it must return an empty string.
     * Note this value is returned internally to PHP for processing.
     * </p>
     * @since 5.4.0
     */
    public function read($session_id)
    {
        $select_query = "SELECT * FROM sessions WHERE id='$session_id' ORDER BY timestamp DESC LIMIT 1";
        $result = $this->getDB()->query($select_query)->fetchArray(SQLITE3_ASSOC);

        if(!empty($result)){
            $access =  strtotime(time());
            $update_query = "UPDATE sessions SET timestamp = '$access' WHERE id = '$session_id'";
            if($this->getDB()->query($update_query)){
                return $result["data"];
            }else {
                return "";
            }
        }else {
            return "";
        }



        //get first from db with id

        // yoksa false

        //varsa
        /*
         * data = session.data
         * timestamp update
         * return data
         */
    }

    /**
     * Write session data
     * @link https://php.net/manual/en/sessionhandlerinterface.write.php
     * @param string $session_id The session id.
     * @param string $session_data <p>
     * The encoded session data. This data is the
     * result of the PHP internally encoding
     * the $_SESSION superglobal to a serialized
     * string and passing it as this parameter.
     * Please note sessions use an alternative serialization method.
     * </p>
     * @return bool <p>
     * The return value (usually TRUE on success, FALSE on failure).
     * Note this value is returned internally to PHP for processing.
     * </p>
     * @since 5.4.0
     */
    public function write($session_id, $session_data)
    {
        $select_query = "SELECT * FROM sessions WHERE id='$session_id' ORDER BY timestamp DESC LIMIT 1";
        $result = $this->getDB()->query($select_query)->fetchArray(SQLITE3_ASSOC);
        $access =  time();
        if(!empty($result)){
            $update_query = "UPDATE sessions SET timestamp = '$access', data='$session_data' WHERE id = '$session_id'";
            if($this->getDB()->query($update_query)){
                return true;
            }else {
                return false;
            }
        }else {
            $insert_query = "INSERT INTO sessions (id, data,timestamp) VALUES ('$session_id', '$session_data', '$access')";
            if($this->getDB()->query($insert_query)){
                return true;
            }else {
                return false;
            }
        }
    }
}

$handler = new CustomSessionHandler();
session_set_save_handler($handler,true);
session_start();