<?php
/**
 * YAWIK
 * 
 * @filesource
 * @copyright (c) 2013-2015 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

namespace YawikCompanyRegistration\Controller;

use Core\Controller\AbstractCoreController;
use Core\Entity\PermissionsInterface;
use Zend\Stdlib\AbstractOptions;
use Zend\View\Model\ViewModel;
use Auth\Entity\UserInterface;
use Auth\Service\Exception\UserAlreadyExistsException;

/**
 * Class RegistrationController
 * @package Registration\Controller
 */
class RegistrationController extends AbstractCoreController
{
    /**
     * @var AbstractOptions
     */
    protected $options;

    /**
     * Module options
     *
     * @param AbstractOptions $options
     */
    public function __construct(AbstractOptions $options)
    {
        //parent::__construct();
        $this->options = $options;
        return $this;
    }

    /**
     * @return array|ViewModel
     */
    public function indexAction ()
    {
        $request                  = $this->getRequest();
        $services                 = $this->getServiceLocator();
        $repositories             = $services->get('repositories');
        $repositoriesOrganization = $repositories->get('Organizations/Organization');
        $registerService          = $services->get('Auth\Service\Register');
        $logger                   = $services->get('Core/Log');
        $formManager              = $services->get('FormElementManager');
        $config                   = $services->get('Config');
        $captchaConfig            = isset($config['captcha']) ? $config['captcha'] : array();
        $form                     = $formManager->get('Registration\Form\Register', array('captcha' => $captchaConfig));
        $formLogin                = $formManager->get('Auth\Form\Login');
        $formLogin->setAttribute("action","/de/login?ref=".urlencode("/de/jobs/edit")."&req=1");
        $formLogin->setAttribute("class","form-horizontal");
        $viewModel                = new ViewModel();

        if ($request->isPost()) {
            $form->setData($request->getPost()->toArray() ?: array());
            if ($form->isValid()) {
                try {
                    $mailer = $this->getPluginManager()->get('Mailer');
                    $url = $this->plugin('url');

                    // we cannot check reCaptcha twice (security protection) so we have to remove it
                    $register = $form->get('register');
                    $name = $register->get('name')->getValue();
                    $email = $register->get('email')->getValue();
                    $user = $registerService->proceedWithEmail($name, $email, $mailer, $url);

                    if (isset($user) && $user instanceof UserInterface) {
                        $user->info->houseNumber = $register->get('houseNumber')->getValue();
                        $user->info->phone = $register->get('phone')->getValue();
                        $user->info->postalCode = $register->get('postalCode')->getValue();
                        $user->info->city = $register->get('city')->getValue();
                        $user->info->street = $register->get('street')->getValue();
                        $repositories->store($user);

                        $organizationName = $register->get('organizationName')->getValue();
                        $organization = $repositoriesOrganization->createWithName($organizationName);
                        $organization->contact->postalcode = $register->get('postalCode')->getValue();
                        $organization->contact->city = $register->get('city')->getValue();
                        $organization->contact->street = $register->get('street')->getValue();
                        $organization->contact->houseNumber = $register->get('houseNumber')->getValue();
                        $organization->user = $user;

                        $permissions = $organization->getPermissions();
                        $permissions->grant($user, PermissionsInterface::PERMISSION_ALL);
                        $repositories->persist($organization);

                        $viewModel->setTemplate('registration\completed');

                        $this->notification()->success(
                        /*@translate*/ 'An Email with an activation link has been sent, please try to check your email box'
                        );
                        $logger->info('Mail first-login sent to ' . $user->info->getDisplayName() . ' (' . $email . ')');

                    }
                    else {
                        // this branch is obsolete unless we do decide not to use an exception anymore, whenever something goes wrong with the user
                        $this->notification()->danger(
                        /*@translate*/ 'User can not be created'
                        );
                    }
                }
                catch (UserAlreadyExistsException $e) {

                    $this->notification()->danger(
                        /*@translate*/ 'User can not be created'
                    );

                    $this->notification()->info(
                         json_encode(array('message' => /*@translate*/ 'user with this e-mail address already exists', 'target' => 'register-email-errors'))
                    );
                }
                catch (\Exception $e) {
                    $this->notification()->danger(
                    /*@translate*/ 'Please fill form correctly'
                    );
                }
            } else {
                $messages = $form->getMessages();
                $this->notification()->danger(
                /*@translate*/ 'Please fill form correctly'
                );
            }
        }
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('formLogin', $formLogin);

        return $viewModel;
    }

}