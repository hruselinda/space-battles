<?php

require 'bootstrap.php';

use Service\Container;


$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

$ship1Id = isset($_POST['ship1_id']) ? $_POST['ship1_id'] : null;
$ship1Quantity = isset($_POST['ship1_quantity']) ? $_POST['ship1_quantity'] : 1;
$ship2Id = isset($_POST['ship2_id']) ? $_POST['ship2_id'] : null;
$ship2Quantity = isset($_POST['ship2_quantity']) ? $_POST['ship2_quantity'] : 1;

if (!$ship1Id || !$ship2Id) {
    header('Location: index.php?error=missing_data');
    die;
}

$ship1 = $shipLoader->findOneById($ship1Id);
$ship2 = $shipLoader->findOneById($ship2Id);

if (!$ship1 || !$ship2) {
    header('Location: index.php?error=bad_ships');
    die;
}

if ($ship1Quantity <= 0 || $ship2Quantity <= 0) {
    header('Location: index.php?error=bad_quantities');
    die;
}


$battleManager = $container->getBattleManager();
$battleType = $_POST['battle_type'];
$battleResult = $battleManager->battle($ship1, $ship1Quantity, $ship2, $ship2Quantity, $battleType);
?>

<html>
    <head>
        <meta charset="utf-8">
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <title>OO Battleships</title>

           <!-- Bootstrap -->
           <link href="css/bootstrap.min.css" rel="stylesheet">
           <link href="css/style.css" rel="stylesheet">
           <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
           <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
           
           <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
           <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
           <!--[if lt IE 9]>
             <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
             <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
           <![endif]-->
    </head>

    <body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header">
                    <a href="index.php"><h1><i class="fa fa-bolt"></i> Space Battles <i class="fa fa-bolt"></i></h1></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-xs-1"></div>
            <div class="col-sm-8 col-xs-10 result-box center-block border">
                <div class="row">
                    <h1 class="text-center audiowide">
                        <?php if ($battleResult->isThereAWinner()): ?>
                            Winner : <i class="fa fa-trophy"></i>
                            <?php echo $battleResult->getWinningShip()->getName(); ?>
                        <?php else: ?>
                            Nobody <i class="fa fa-flag-o"></i>
                        <?php endif; ?>
                    </h1>
                    <p class="text-center">
                        <?php if (!$battleResult->isThereAWinner()): ?>
                        The ships destroyed each other in an epic battle to the end.
                    <div class="hidden-xs nobody-wins"></div>
                    <div class="visible-xs nobody-wins-xs"></div>
                    <?php else: ?>
                        The <?php echo $battleResult['winningShip']->getName(); ?>
                        <?php if ($battleResult->wereJediPowersUsed()): ?>
                            used its Jedi Powers for a stunning victory!
                            <div class="hidden-xs jedi-power-wins"></div>
                            <div class="visible-xs jedi-power-wins-xs"></div>
                        <?php else: ?>
                            overpowered and destroyed the <?php echo $battleResult->getLosingShip()->getName(); ?>
                            <div class="hidden-xs destroyed"></div>
                            <div class="visible-xs destroyed-xs"></div>
                        <?php endif; ?>
                    <?php endif; ?>
                    </p>
                </div>
                <div class="row">
                    <div class="after-battle">
                        <h4 class="text-center audiowide">After this epic battle:</h4>
                        <div class="row">
                            <p class="text-center">Team Z ' <?php echo $ship1->getName()?> has <?php echo $ship1->getStrength()?> power left</p>
                        </div>
                        <div class="row">
                            <p class="text-center">Team X ' <?php echo $ship2->getName()?> has <?php echo $ship2->getStrength()?> power left</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-2 col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="#" onClick="window.location.reload( true );"><p class="text-center"><i class="fa fa-undo"></i> Re-match! </p></a>
                <a href="index.php"><p class="text-center"><i class="fa fa-bolt"></i> Another Battle</p></a>
                <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/bootstrap.min.js"></script>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <footer>
                    <p class="text-center">Powered by Hruselinda &copy; 2017</p>
                </footer>
            </div>
        </div>
    </div>

    </body>
</html>
