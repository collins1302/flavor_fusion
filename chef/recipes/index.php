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
                        <h4 class="pull-left">List of Recipes</h4>

                        <a href="../home.php" class="btn btn-primary pull-right" id="btn_dashboard">Dashboard</a>
                        <a href="create.php" class="btn btn-success pull-right" style="margin-right: 5px;"> Add New
                            Recipe</a>

                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Initialize the session
                    session_start();
                    
                    // Check if session username is set
                    if(isset($_SESSION["username"])) {
                        $chef_username = $_SESSION["username"];

                        // Attempt select query execution
                        $sql = "SELECT * FROM recipes_table WHERE chef_username = ?";
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind the parameter
                            mysqli_stmt_bind_param($stmt, "s", $chef_username);

                            // Execute the statement
                            if(mysqli_stmt_execute($stmt)){
                                // Get the result set
                                $result = mysqli_stmt_get_result($stmt);

                                // Check if there are any rows
                                if(mysqli_num_rows($result) > 0){
                                    // Display the rows
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
                                echo "ERROR: Could not execute $sql. " . mysqli_error($link);
                            }

                            // Close the statement
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "ERROR: Could not prepare SQL statement.";
                        }
                    } else {
                        echo "ERROR: Session username is not set.";
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