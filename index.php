<?php
require 'bootstrap.php';

use Service\BattleManager;
use Service\Container;
//use Model\RebelShip;
//use Model\BrokenShip;


$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

/*
 * Two types of dhips - RebelShip and BrokenShip - that were made for an exercise. They are not in the DB
 */
/*
    $rebelShip = new RebelShip('Brand new ship');
    $ships[] = $rebelShip;


    $brokenShip = new BrokenShip('I am broken, man');
    $brokenShip->weaponPower;
    /*
    try {
        $brokenShip->name;
    } catch(Exception $e) {
        echo $e->getMessage();
    }

$ships[] = $brokenShip;

$ships->removeAllBrokenShips();
*/

$battleTypes = BattleManager::getAllBattleTypesWithDescription();


$errorMessage = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_data':
            $errorMessage = 'Don\'t forget to select some ships to battle!';
            break;
        case 'bad_ships':
            $errorMessage = 'You\'re trying to fight with a ship that\'s unknown to the galaxy?';
            break;
        case 'bad_quantities':
            $errorMessage = 'You picked strange numbers of ships to battle - try again.';
            break;
        default:
            $errorMessage = 'There was a disturbance in the force. Try again.';
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <title>Space Battles</title>

           <!-- Bootstrap -->
           <link href="css/bootstrap.min.css" rel="stylesheet">
           <link href="css/style.css" rel="stylesheet">
           <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

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
                <?php if ($errorMessage): ?>
                    <div class="error">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header">
                    <a href="index.php"><h1><i class="fa fa-bolt"></i> Space Battles <i class="fa fa-bolt"></i></h1></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10 col-xs-12">
                    <table class="table table-hover border">
                        <caption><i class="fa fa-check-square-o"></i> On your commands, Captain! </caption>
                        <thead>
                        <tr>
                            <th><i class="fa fa-fighter-jet"></i>  All ships</th>
                            <th><i class="fa fa-shield"></i> <span class="hidden-xs">Defence</span></th>
                            <th><i class="fa fa-rocket"></i> <span class="hidden-xs">Fighting Power</span></th>
                            <th><i class="fa fa-magic"></i> <span class="hidden-xs">Jedi Power</span></th>
                            <!-- <th><i class="fa fa-location-arrow"></i> Team</th> -->
                            <th> <span class="hidden-xs">Ready for battle</span><a href="#" onClick="window.location.reload( true );"> <i class="fa fa-undo"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($ships as $ship): ?>
                            <tr>
                                <td><?php echo $ship -> getName(); ?></td>
                                <td><?php echo $ship -> getWeaponPower(); ?></td>
                                <td><?php echo $ship -> getStrength(); ?></td>
                                <td><?php echo $ship -> getJediFactor(); ?></td>
                                <!-- <td><?php echo $ship -> getType(); ?></td> -->
                                <td>
                                    <?php if($ship->isFunctional()): ?>
                                        <i class="fa fa-check"></i>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <div class="col-sm-1"></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8 col-xs-12">
                <form class=" battle-box border" method="POST" action="battle.php">
                    <h2 class="text-center">battle</h2>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="pull-left" for="ship1"> Team Z </label>
                            <input class="form-control text-field" type="text" name="ship1_quantity" placeholder="Quantity" />
                            <select class="form-control btn drp-dwn-width btn-default dropdown-toggle" name="ship1_id">
                                <?php foreach ($ships as $ship): ?>
                                    <?php if($ship->isFunctional()): ?>
                                        <option value="<?php echo $ship->getId(); ?>"><?php echo $ship -> getName(); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="clear"></div>
                        </div>
                        <div class="col-sm-4 vs"></div>
                        <div class="col-sm-4">
                            <label class="hidden-xs pull-right" for="ship2"> Team X </label>
                            <label class="visible-xs pull-left" for="ship2"> Team X </label>
                            <input class="pull-right form-control text-field" type="text" name="ship2_quantity" placeholder="Quantity" />
                            <select class="pull-right form-control btn drp-dwn-width btn-default dropdown-toggle" name="ship2_id" >
                                <?php foreach ($ships as $ship): ?>
                                    <?php if($ship->isFunctional()): ?>
                                        <option value="<?php echo $ship->getId(); ?>"><?php echo $ship -> getName(); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="visible-xs space-for-battle"></div>
                            <label>Battle type</label>
                            <select name="battle_type" id="battle_type" class="form-control drp-dwn-width">
                                <?php foreach ($battleTypes as $battleType => $typeText): ?>
                                    <option value="<?php echo $battleType?>"><?php echo $typeText; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <div class="visible-xs space-for-battle"></div>
                            <div class="visible-xs space-for-battle"></div>
                            <label class="pull-right">3, 2, 1 ...</label>
                            <div class="clear"></div>
                            <button class="pull-right btn btn-md btn-danger" type="submit">May the Force be with them!</button>
                            <div class="clear"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-2"></div>
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
