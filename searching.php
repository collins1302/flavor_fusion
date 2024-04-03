<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Searched Recipes</title>
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

    button {
        align
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <center>
                        <h1>Flavor Fusion</h1>
                        <h4>Where Flavors Unite, Creations Ignite!</h4>
                    </center>
                    <h4 class="pull-left">Searched Recipes</h4>

                    <form class="pull-right" action="searching.php" method="GET" style="display: flex;">
                        <input type="text" name="search" required
                            value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>"
                            class="form-control me-2 mr-5" placeholder="location or category"
                            style="margin-right: 5px;">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Ingredients</th>
                                    <th>Preparation Instructions</th>
                                    <th>Servings</th>
                                    <th>Location</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","flavor_fusion");

                                    if(isset($_GET['search']))
                                    {
                                        $filtervalues = $_GET['search'];
                                        // $query = "SELECT * FROM recipes_table WHERE CONCAT(id) LIKE '%$filtervalues%' ";
                                        $query = "SELECT * FROM recipes_table WHERE CONCAT(location, ' ', category) LIKE '%$filtervalues%' ";
                                        $query_run = mysqli_query($con, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                                ?>
                                <tr>
                                    <td><?= $items['recipe_id']; ?></td>
                                    <td><?= $items['recipe_name']; ?></td>
                                    <td><?= $items['ingredients']; ?></td>
                                    <td><?= $items['preparation_instructions']; ?></td>
                                    <td><?= $items['servings']; ?></td>
                                    <td><?= $items['location']; ?></td>
                                    <td><?= $items['category']; ?></td>
                                </tr>
                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                <tr>
                                    <td colspan="4">"No recipes matching the specified location and category were
                                        found.".</td>
                                </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <a href="index.php" class="btn btn-primary pull-right" id="btn_dashboard">Available Recipes</a>

            </div>
        </div>
    </div>

</body>

</html>