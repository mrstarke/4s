<?php

function execute($command){
    if (isset($_SESSION['auth'])){
        if (isset($_SESSION['server']))
            exec('ssh -o StrictHostKeyChecking=no -i /tmp/id_rsa ' . $_SESSION['server'] . ' ' . $command,$output);
        else
            exec($command,$output);
        return $output;
    }
}

function auth(){
    global $password;
    if (isset($_SESSION['parameter']) && ($_SESSION['parameter'] == $password)){
        $_SESSION['auth'] = 1;
        unset($_SESSION['parameter']); 
    }
}

function unauth(){
    session_destroy();
}

function server(){
    if (isset($_SESSION['parameter']) && ($_SESSION['parameter'] == 'local'))
        unset($_SESSION['server']);
    else
       if (isset($_SESSION['parameter'])){
           $_SESSION['server'] = $_SESSION['parameter'];
       }
}

function top(){
    return execute('top -b -n -1');
}

function df(){
    return execute('df -m');
}

function free(){
    return execute('free -m');
}

function vmstat(){
    return execute('vmstat -s');
}

function logs(){
    return execute('tail /var/log/messages');
}
?>
