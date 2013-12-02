<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');
App::uses('CakeOptimizer','CakeOptimizePdf.Optimizer');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    function beforeFilter(){
//        App::uses('FormatOptimizer', 'CakeOptimizePdf.Optimizer/Engine');
//        if (!class_exists('FormatOptimizer')) {
//            throw new CakeException(__d('cake_optimizer', 'Optimizer engine "%s" not found', 'Format'));
//        }
//        if (!is_subclass_of('FormatOptimizer', 'AbstractOptimizer')) {
//            throw new CakeException(__d('cake_optimizer', 'Optimizer engines must extend "AbstractOptimizer"'));
//        }
//        $optimizer = new CakeOptimizer('/tmp/test.pdf');
//        $optimizer->filename('qs');
//        debug($optimizer->optimize());
    }

}
