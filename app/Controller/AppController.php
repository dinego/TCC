<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
// app/Controller/AppController.php
class AppController extends Controller {
    //...

    public $helpers = array('Session');

    public $components = array(
        'Flash',
        'Auth' => array(
            'loginRedirect' => array('/'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
            'authorize' => array('Controller') // Adicionamos essa linha
        )
    );

    public function isAuthorized($user) {
        if (!empty($user['role']) && $user['role'] === 'admin' || $user['role'] === 'prof') {
            return true; // Admin pode acessar todas actions
        } else if (!empty($user['role']) && $user['role'] === 'aluno') {
            if (in_array($this->action, array('index', 'ativ_alunos', 'atividade', 'login', 'profile_edit', 'resumo', 'getPontos'))) {
                return true;
            } else {
                return false;
            }
            $this->redirect(array('controller' => 'alunos', 'action' => 'index'));
        } else {
            return false;
        }
    }

    function beforeFilter() {
        $this->Auth->allow('index', 'view');
    }    

    public function beforeRender() {
    	$user = $this->Auth->user();
	    $this->set('user', $user);
	}
}
