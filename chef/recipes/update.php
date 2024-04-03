<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$recipe_id = $recipe_name = $ingredients = $preparation_instructions = $servings = $location = $category = "";
$recipe_id_err = $recipe_name_err = $ingredients_err = $preparation_instructions_err = $servings_err = $location_err = $category_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate recipe name
    $input_recipe_name = trim($_POST["recipe_name"]);
    if(empty($input_recipe_name)){
        $recipe_name_err = "Please enter recipe name.";
    } else{
        $recipe_name = $input_recipe_name;
    }

    // Validate ingredients
    $input_ingredients = trim($_POST["ingredients"]);
    if(empty($input_ingredients)){
        $ingredients_err = "Please enter ingredients.";
    } else{
        $ingredients = $input_ingredients;
    }

    // Validate preparation instructions
    $input_preparation_instructions = trim($_POST["preparation_instructions"]);
    if(empty($input_preparation_instructions)){
        $preparation_instructions_err = "Please enter preparation instructions.";
    } else{
        $preparation_instructions = $input_preparation_instructions;
    }

    // Validate servings
    $input_servings = trim($_POST["servings"]);
    if(empty($input_servings)){
        $servings_err = "Please enter recipe servings.";
    } else{
        $servings = $input_servings;
    }

    // Validate location
    $input_location = trim($_POST["location"]);
    if(empty($input_location)){
        $location_err = "Please enter location.";
    } else{
        $location = $input_location;
    }

    // Validatecategory
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        $category_err = "Please enter category.";
    } else{
        $category = $input_category;
    }
    
    // Check input errors before inserting in database
     if(empty($recipe_name_err) && empty($ingredients_err) && empty($preparation_instructions_err) && empty($servings_err) && empty($location_err) && empty($category_err)){
        // Prepare an update statement
        $sql = "UPDATE recipes_table SET recipe_name=?, ingredients=?, preparation_instructions=?, servings=?, location=?, category=? WHERE recipe_id=?";
        
        // `recipe_id`, `recipe_name`, `ingredients`, `preparation_instructions`, `servings`, `location`, `category`
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_recipe_name, $param_ingredients, $param_preparation_instructions, $param_servings, $param_location, $param_category,  $param_id);
            
            // Set parameters
            $param_recipe_name = $recipe_name;
            $param_ingredients = $ingredients;
            $param_preparation_instructions = $preparation_instructions;
            $param_servings = $servings;
            $param_location = $location;
            $param_category = $category;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM recipes_table WHERE recipe_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $recipe_name = $row["recipe_name"];
                    $ingredients = $row["ingredients"];
                    $preparation_instructions = $row["preparation_instructions"];
                    $servings = $row["servings"];
                    $location = $row["location"];
                    $category = $row["category"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Recipes</title>
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
                        <h2>Update Recipe</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Recipe Name</label>
                            <input type="text" name="recipe_name" class="form-control"
                                value="<?php echo $recipe_name; ?>">
                            <span class="help-block"><?php echo $recipe_name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($ingredients_err)) ? 'has-error' : ''; ?>">
                            <label>Ingredients</label>
                            <input type="text" name="ingredients" class="form-control"
                                value="<?php echo $ingredients; ?>">
                            <span class="help-block"><?php echo $ingredients_err;?></span>
                        </div>

                        <div
                            class="form-group <?php echo (!empty($preparation_instructions_err)) ? 'has-error' : ''; ?>">
                            <label>Preparation Instructions</label>
                            <textarea name="preparation_instructions" class="form-control"
                                style="height: 160px;"><?php echo $preparation_instructions; ?></textarea>
                            <span class="help-block"><?php echo $preparation_instructions_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($servings_err)) ? 'has-error' : ''; ?>">
                            <label>Servings</label>
                            <input type="text" name="servings" class="form-control" value="<?php echo $servings; ?>">
                            <span class="help-block"><?php echo $servings_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($location_err)) ? 'has-error' : ''; ?>">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="<?php echo $location; ?>">
                            <span class="help-block"><?php echo $location_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control" value="<?php echo $category; ?>">
                            <span class="help-block"><?php echo $category_err;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>