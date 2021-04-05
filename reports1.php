<?php
    $where = '';

    if (isset($_POST['and'])) {

        if(isset($_REQUEST['dancer_name'])){
            $name = $_REQUEST['dancer_name'];
            if ($name != "") {
                $where = "WHERE d.name='$name'";
            }
        }
        if(isset($_REQUEST['team_name'])){
            $team = $_REQUEST['team_name'];
            if ($team != "") {
                if ($where == "") {
                    $where = "WHERE t.team_name ='$team'";
                } else {
                    $where = "$where AND team_name ='$team'";
                }
            }
        }
        if(isset($_REQUEST['day'])){
            $day = $_REQUEST['day'];
            if ($day != "") {
                if ($where == "") {
                    $where = "WHERE s.day ='$day'";
                } else {
                    $where = "$where AND s.day ='$day'";
                }
            }
        }
    } else {
        if(isset($_REQUEST['dancer_name'])){
            $name = $_REQUEST['dancer_name'];
            if ($name != "") {
                $where = "WHERE d.name='$name'";
            }
        }
        if(isset($_REQUEST['team_name'])){
            $team = $_REQUEST['team_name'];
            if ($team != "") {
                if ($where == "") {
                    $where = "WHERE t.team_name ='$team'";
                } else {
                    $where = "$where OR team_name ='$team'";
                }
            }
        }
        if(isset($_REQUEST['day'])){
            $day = $_REQUEST['day'];
            if ($day != "") {
                if ($where == "") {
                    $where = "WHERE s.day ='$day'";
                } else {
                    $where = "$where OR s.day ='$day'";
                }
            }
        }
    }
 

    //1 Conectar a BD 
    $host = "localhost";
    $dbname = "dance_academy2_bd";
    $username = "root";
    $password = "";

    $cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //2. Construir la sentencia SQL
    $sql = "SELECT d.name AS dancer_name, d.age, d.eps, t.team_name, s.day, s.time FROM dancer AS d JOIN schedule AS s ON d.id = s.id_dancer JOIN team AS t ON s.id_team = t.id $where ORDER BY d.name asc" ;
     
    //3.Preparar la sentencia SQL 
    $q = $cnx->prepare($sql);

    //4. Ejecutar la sentencia SQL
    $resul= $q->execute();

    $schedules = $q-> fetchAll();


?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="POST" action="reports1.php">
        <h1> Filters</h1>
            Name: 
            <input type="text" name="dancer_name" value="<?php echo $name;?>"/>
            <br>
            Team:
            <select name="team_name">
                <option value="">team</option>
                <option value="Semillas">Semillas</option>
                <option value="Project" >Project</option>
                <option value="Profesional">Profesional</option>
                <option value="Sumo">Sumo</option>
                <option value="Adultos">Adultos</option>
            </select> 
            <?php echo "Team: $team" ;?>
            <br>
            Schedule Day: 
            <select name="day">
            <option value="">day</option>
                <option value="Lunes">Lunes</option>
                <option value="Martes" >Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sabado</option>
            </select> 
            <?php echo "Day: $day";?>
            <br>
            <input type="submit" name="and" value="Search AND">
            <input type="submit" name="or" value="Search OR">

        </form>
            
        <form method="POST" action="reports.php">
            <input type="submit" value="Back">
        </form>

        <hr>
        <h1> Schedules list</h1>
        <table border="1">
            <tr>
                <td>Name</td>
                <td>Age</td>
                <td>Eps</td>
                <td>Team name</td>
                <td>Day</td>
                <td>Time</td>
            </tr>
<?php
    for ($i = 0; $i<count($schedules); $i++){
?>
            <tr>
                <td>
                    <?php echo $schedules[$i]["dancer_name"]?>
                </td>
                <td>
                    <?php echo $schedules[$i]["age"]?>
                </td>
                <td>
                    <?php echo $schedules[$i]["eps"]?>
                </td>
                <td>
                    <?php echo $schedules[$i]["team_name"]?>
                </td>
                <td>
                    <?php echo $schedules[$i]["day"]?>
                </td>
                <td>
                    <?php echo $schedules[$i]["time"]?>
                </td>
                
            </tr>
<?php
    }
?>            
        </table>
    </body>
</html>