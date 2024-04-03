<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM recipes_table WHERE recipe_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
               
                // Retrieve individual field value
                $recipe_id = $row["recipe_id"];
                $recipe_name = $row["recipe_name"];
                $ingredients = $row["ingredients"];
                $preparation_instructions = $row["preparation_instructions"];
                $servings = $row["servings"];
                $location = $row["location"];
                $category = $row["category"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Recipes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    .wrapper {
        width: 500px;
        margin: 0 auto;
    }

    /* On screens that are 600px or less, set the background color to olive */
    @media screen and (max-width: 600px) {
        .wrapper {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Recipe</h1>
                    </div>

                    <div class="form-group">
                        <label>Recipe ID</label>
                        <p class="form-control-static"><?php echo $row["recipe_id"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Recipe Name</label>
                        <p class="form-control-static"><?php echo $row["recipe_name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Ingredients</label>
                        <p class="form-control-static"><?php echo $row["ingredients"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Preparation Instructions</label>
                        <p class="form-control-static"><?php echo $row["preparation_instructions"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Servings</label>
                        <p class="form-control-static"><?php echo $row["servings"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <p class="form-control-static"><?php echo $row["location"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <p class="form-control-static"><?php echo $row["category"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>