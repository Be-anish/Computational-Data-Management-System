<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Non-Teaching Department</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./branch-style.css">
</head>

<body>
    <?php include('./header.php'); ?>
    <?php require_once('../db_connection.php'); ?>
    <div style='width:90%; margin:auto auto; padding:6px;'>
    <div style='width:90vw; margin:auto auto; font-weight:700; color:blue'>Summary of computational items assigned to Non-Teaching dept:
<marquee behaviour="scroll" direction="left" scrollamount="4" style="font-size: 16px;padding-top: 0px;font-weight:550; margin:auto auto; color:blue">
    <?php
    $q1 = "SELECT DISTINCT item_type from computational_items";
    $r = mysqli_query($connection, $q1);
    while ($re = mysqli_fetch_assoc($r)) {
        $item_type = $re['item_type'];
        $query = "SELECT SUM({$item_type}) as {$item_type} ";
        $query .= "FROM no_items_assigned NATURAL JOIN department WHERE dept_type='nonteaching'; ";
        $list = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($list)) {
            echo "<div style='display:inline; margin-right:1vw;'><em>Number of {$item_type}: {$row[$item_type]}</em></div>";
        }
    }
    ?>
    </marquee>
    </div></div>
    <?php
    $query = "SELECT faculty.id as id, faculty.name, department.dept_name,department.designation FROM department,faculty WHERE department.id=faculty.id AND dept_type='nonteaching' Order by faculty.id+0; ";
    $list = mysqli_query($connection, $query); ?>
    <form method='get' action='./proflist.php' style='width:90%; margin:auto auto;'>
        <input type="Submit" name="View Items" value="View items" /><br />
        <table id="tableId">
            <tr class="thead">
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($list)) {
                $output = "<tr id='{$row['id']}' onclick='hover_click(this.id)'><label for='{$row['id']}'><td><input name='radio'  id='{$row['id']}' type='radio' value='{$row['id']}'/></td>";
                foreach ($row as $x => $x_value) {
                    $output .= "<td>";
                    $output .= $x_value;
                    $output .= "</td>";
                }
                $output .= "</label></tr>";
                echo $output;
            }
            ?>
        </table>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        function hover_click(id) {
            console.log(id);
           var radio= document.getElementById(id+" ").checked = true;
        }
    </script>


</body>

</html>