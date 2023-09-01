<html>
    <head>
        <title>SQL-Injection Demo</title>
    </head>
    <body>
        <form action="/index.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Passwort:</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="Anmelden" style="margin-top: 10px">
        </form>
        <br> 
        <?php 
            if ( isset($_POST['username']) and isset($_POST['password']))
            {
                $newhash = md5($_POST['password']);
                
                $DBCONN = pg_connect("host=/var/run/postgresql dbname=sqlinjection_demo user=pooradmin password=sehrschwachespasswort");
                $query = "select username, passwort from tb_user where username=" . "'" . $_POST['username'] . "'";
                $query_result = pg_query($DBCONN, $query);
                if(!$query_result){
                    echo '<p>Etwas ging schief :/</p>';
                }
                $row = pg_fetch_row($query_result);

                if ( $row[1] == $newhash){                    
                    echo "Hallo " . $row[0];
                }else{
                    echo '<p style="color: red">Falsches Passwort für Nutzer <b style="color: black">'. $row[0] .'</b></p>';
                }
            }
            
        ?>
    </body>
</html>