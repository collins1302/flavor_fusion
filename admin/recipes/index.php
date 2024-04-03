<?php
// Include config file
require_once "config.php";

// Query to count the number of chefs
$sql_chefs = "SELECT COUNT(*) AS total_chefs FROM users";
$result_chefs = mysqli_query($link, $sql_chefs);
$row_chefs = mysqli_fetch_assoc($result_chefs);
$total_chefs = $row_chefs['total_chefs'];

// Query to count the number of recipes
$sql_recipes = "SELECT COUNT(*) AS total_recipes FROM recipes_table";
$result_recipes = mysqli_query($link, $sql_recipes);
$row_recipes = mysqli_fetch_assoc($result_recipes);
$total_recipes = $row_recipes['total_recipes'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Recipes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>

    <style type="text/css">
    .wrapper {
        width: 80%;
        margin: 0 auto;
    }

    .page-header h2 {
        margin-top: 0;
    }

    table tr td:last-child a {
        margin-right: 15px;
    }

    /* On screens that are 600px or less, set the background color to olive */
    @media screen and (max-width: 600px) {
        .wrapper {
            width: 100%;

        }
    }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
</head>

<body>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <center>
                            <h1>Flavor Fusion</h1>
                            <h4>Where Flavors Unite, Creations Ignite!</h4>
                        </center>
                        <h4 class="pull-left" style="margin-right: 20px">Number of Chef's: <?php echo $total_chefs; ?>
                        </h4>
                        <h4 class="pull-left"> Available Recipes:
                            <?php echo $total_recipes; ?></h4>
                        <a href="../home.php" class="btn btn-primary pull-right" id="btn_dashboard">Dashboard</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM recipes_table";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Recipe ID</th>";
                                        echo "<th>Recipe Name</th>";
                                        echo "<th>Servings</th>";
                                        echo "<th>Location</th>";
                                        echo "<th>Category</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['recipe_id'] . "</td>";
                                        echo "<td>" . $row['recipe_name'] . "</td>";
                                        echo "<td>" . $row['servings'] . "</td>";
                                        echo "<td>" . $row['location'] . "</td>";
                                        echo "<td>" . $row['category'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['recipe_id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['recipe_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['recipe_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>