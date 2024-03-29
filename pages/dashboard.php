<?php
// including session.php file for user authentication
include("session.php");
//this query is to get the three most sold products
$cost = mysqli_query($con, "SELECT warehouse.name as pname FROM sell   join warehouse on warehouse= id where user_id='$user_id' group by pname ORDER BY quantity_sell,year(sell.time_date) DESC  LIMIT 3 ");
//this query is to get the revenue/profit
$sell = mysqli_query($con, "SELECT SUM(warehouse.cost)as cost, SUM(price) as price FROM  sell join warehouse on warehouse.id=sell.warehouse WHERE user_id = '$user_id'");
//this query is for the bar chart
$charts = mysqli_query($con, "SELECT sell.time_date as time_date FROM `sell` inner join warehouse on warehouse.id=sell.warehouse where sell.user_id='$user_id' group by year(sell.time_date),warehouse.name;");
$charts2 = mysqli_query($con, "SELECT warehouse.name as pname FROM `warehouse` inner join sell on warehouse.id=sell.warehouse where sell.user_id='$user_id' group by year(sell.time_date),pname;");
//this query is for the line chart
$charts3 = mysqli_query($con, "SELECT sum(sell.quantity_sell) as Q   FROM sell  join warehouse on warehouse= id where user_id='$user_id' group by warehouse.name");
$charts4 = mysqli_query($con, "SELECT  warehouse.name as pname  FROM sell  join warehouse on warehouse= id where user_id='$user_id' group by warehouse.name ");
//this query is for the PoalarArea chart
$area = mysqli_query($con, "SELECT quantity  FROM `warehouse` where user='$user_id'  group by name ,quantity");
$area2 = mysqli_query($con, "SELECT name  FROM `warehouse` where user='$user_id'  group by name ,quantity");
$businessname = mysqli_query($con, "SELECT  businessname  FROM user  where id='$user_id'");
// this gets the business name
while ($row = mysqli_fetch_assoc($businessname)) {
    $bname = $row['businessname'];
};
//this gets the revenue/profit
while ($row = mysqli_fetch_assoc($sell)) {
    $cost_price = $row['cost'];
    $price = $row['price'];
    $revenue = (float)$price - (float)$cost_price;
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../logo/icon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,400;0,600;1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script src="../js/translate.js"></script>
    <link href="../css/css.css" rel="stylesheet" />
    <title>Dashboard</title>
</head>
<!--this calls a function in js to translate the website-->

<body id="text" onload="translate('en','lang-tag');">
    <section>
        <div class=" navbar navbar-expand-sm navbar-light bg-lightPink shadow text-center">
            <div class="container p-0">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span><img src="../logo/logo.png" alt="" width="25"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbar">
                    <ul class="navbar-nav mt-2 mt-lg-0 " id="navigation">
                        <li class="navbar-brand" value=" 1">
                            <img class="img-fluid" src="../logo/logo.png" alt="" width="25">
                        </li>
                        <li class="nav-item " value=" 2">
                            <a class="nav-link" href=" dashboard.php" lang-tag="dashboared"></a>
                        </li>
                        <li class="nav-item " value="3">
                            <a class="nav-link" href="add-catagory.php" lang-tag="addCategory"></a>
                        </li>
                        <li class="nav-item " value="4">
                            <a class="nav-link" href="history.php" lang-tag="expenseHistory"></a>
                        </li>
                        <li class="nav-item " value="5">
                            <a class="nav-link" href="werehouse.php" lang-tag="werehouse"></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mt-2 mt-lg-0" id="user">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
                                <?php echo $bname; ?>
                            </a>
                            <ol class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#custom" lang-tag="customize"></li>
                                <li><a class="dropdown-item" href="profile.php" lang-tag="profile"></a></li>
                                <li><a class="dropdown-item" href="logout.php" lang-tag="logout"></a></li>
                            </ol>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal fade" id="custom" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" lang-tag="customize" id="customModalLabel"></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container  mx-auto text-center">
                                <div class="conatiner ">
                                    <label lang-tag="changeLang"></label>
                                    <div class="d-flex justify-content-center">
                                        <a class=" btn m-3" onclick="en()" id="enTranslator" href="javascript:void(0);">EN</a>
                                        <a class=" btn m-3" onclick="ar()" id="arTranslator" href="javascript:void(0);">AR</a>
                                    </div>
                                </div>
                                <div class="container">
                                    <label lang-tag="changeFont"></label>
                                    <div class="size-range text-center  pt-3 ">
                                        <input onchange="sizeChange()" class="form-range w-50" id="font-size" type="range" min="1" max="5">
                                    </div>
                                </div>
                                <div class="container">
                                    <p lang-tag="changeTheme"></p>
                                    <div class="form-check form-switch pt-3 text-center ps-0">
                                        <input onchange="toggleTheme()" class="form-check-input float-none checkbox" type="checkbox" role="switch" id="myCheckBox" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mt-3 pt-1 mx-auto">
            <div class="d-md-flex justify-content-sm-center">
                <div class="col-md-6">
                    <div class="container text-center mt-1">
                        <h2 class="text-darkBlue h2" lang-tag="sellCharts"></h2>
                        <div class="charts">
                            <!-- history/sell charts-->
                            <div class="liner">
                                <h4 class="text-lightBlue h4" lang-tag="yearly"></h4>
                                <div class="container">
                                    <canvas id="myChart">
                                    </canvas>
                                </div>
                            </div>
                            <div class="line">
                                <h4 class="text-lightBlue h4" lang-tag="quantity"></h4>
                                <div class="container">
                                    <canvas id="myChart2">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 vr"><!-- the vr is a line to sepatate the col -->
                    <div class="container text-center mt-2 pt-1 justify-content-center">
                        <div class="   shadow rounded p-2 my-3  ">
                            <h2 lang-tag="mostSold" class="h2 text-darkBlue"></h2>
                            <div class="d-sm-flex p-3">
                                <div class="col-sm-8 d-flex">
                                    <?php $count = 1;
                                    while ($row = mysqli_fetch_assoc($cost)) {
                                        if ($count) { ?>

                                            <label class=" ps-4 text-capitalize h6">
                                                <?php echo $count . ". " . $row['pname']; ?>
                                            </label>

                                    <?php }
                                        $count++;
                                    } ?>
                                </div>
                                <div class="col-sm-4">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>
                        <div class="shadow rounded p-3  my-3">
                            <h2 class="h2 text-darkBlue" lang-tag="revenue"></h2>
                            <div class="d-sm-flex p-3">
                                <div class="col-sm-4">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="col-sm-8">
                                    <label class="ps-4 text-capitalize" id="income">
                                        <?php echo $revenue; ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container ">
                        <div class="polerarea"><!--this chart is from thw warehouse-->
                            <h2 class="text-lightBlue text-center h2" lang-tag="werehouse"></h2>
                            <div class="container">
                                <canvas id="myChart3">
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js" integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        //this function changes the color/ border color when the theme is dark
        function color() {
            if (localStorage.getItem("theme") === "theme-dark") {
                Chart.defaults.color = '#000';
                Chart.defaults.borderColor = '#000';
            }
        };
        color();
        //bar chart of the history/sell
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php
                            while ($row = mysqli_fetch_assoc($charts2)) {
                                echo '"' . $row['pname'] . '",';
                            }; ?>],
                datasets: [{
                    label: 'YEARLY',
                    data: [<?php
                            while ($row = mysqli_fetch_assoc($charts)) {
                                echo '"' . explode("-", $row['time_date'])[0] . '",';
                            }; ?>],
                    backgroundColor: [
                        '#ea3745',
                        '#f46161',
                        '#e02c3e',
                        '#d61f37',
                        '#cc0d30'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        type: "time",
                        time: {
                            unit: 'year',
                            tooltipFormat: 'yyyy'
                        },
                        min: '2019',
                    },

                }
            }
        });
        //line chart of history/sell
        const ct = document.getElementById('myChart2');
        new Chart(ct, {
            type: 'line',
            data: {
                labels: [<?php
                            while ($row = mysqli_fetch_assoc($charts4)) {
                                echo '"' . $row['pname'] . '",';
                            }; ?>],
                datasets: [{
                    label: 'sold',
                    data: [
                        <?php
                        while ($row = mysqli_fetch_assoc($charts3)) {
                            echo '"' . $row['Q'] . '",';
                        }; ?>
                    ],
                    backgroundColor: [
                        '#ea3745',
                        '#f46161',
                        '#e02c3e',
                        '#d61f37',
                        '#cc0d30'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                }
            }
        });
        //polarArea chart of warehouse
        const char = document.getElementById('myChart3');
        new Chart(char, {
            type: 'polarArea',
            data: {
                labels: [
                    <?php
                    while ($row = mysqli_fetch_assoc($area2)) {
                        echo '"' . $row['name'] . '",';
                    }; ?>
                ],
                datasets: [{
                    label: 'Quantity in Warehouse',
                    data: [<?php
                            while ($row = mysqli_fetch_assoc($area)) {
                                echo '"' . $row['quantity'] . '",';
                            }; ?>],
                    backgroundColor: [
                        '#ea3745',
                        '#f46161',
                        '#e02c3e',
                        '#d61f37',
                        '#cc0d30'
                    ]
                }]
            }
        });
    </script>
</body>

</html>