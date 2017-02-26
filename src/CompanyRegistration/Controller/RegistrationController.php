<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

namespace CompanyRegistration\Controller;

use Auth\Entity\User;
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
    public function indexAction()
    {
        /* @var $request \Zend\Http\Request */
        $request                  = $this->getRequest();
        $services                 = $this->getServiceLocator();
        $repositories             = $services->get('repositories');
        $repositoriesOrganization = $repositories->get('Organizations/Organization');
        $registerService          = $services->get('Auth\Service\Register');
        $logger                   = $services->get('Core/Log');
        $formManager              = $services->get('FormElementManager');
        /* @var \CompanyRegistration\Form\Register $form  */
        $form                     = $formManager->get('Auth\Form\Register',['role'=>$this->params( User::ROLE_USER, User::ROLE_RECRUITER )]);
        /* @var \Auth\Form\Login $formLogin  */
        $formLogin                = $formManager->get('Auth\Form\Login');
        $formLogin->setAttribute("action", "/de/login?ref=".urlencode("/de/jobs/edit")."&req=1");
        $formLogin->setAttribute("class", "form-horizontal");
        $viewModel                = new ViewModel();

        if ($request->isPost()) {
            $form->setData($request->getPost()->toArray() ?: array());
            if ($form->isValid()) {
                try {
                    $mailer = $this->getPluginManager()->get('Mailer');
                    $url = $this->plugin('url');

                    // we cannot check reCaptcha twice (security protection) so we have to remove it
                    /* @var \Zend\Form\FieldSet $register */
                    $register = $form->get('register');
                    $name = $register->get('name')->getValue();
                    $email = $register->get('email')->getValue();
                    /* @var \Auth\Service\Register $registerService */

                    $registerService->setFormFilter($form->getInputFilter());
                    $user = $registerService->proceedWithEmail($name, $email, $mailer, $url);

                    if (isset($user) && $user instanceof UserInterface) {

                        if(User::ROLE_RECRUITER == $register->get('role')->getValue()) {
                            if ($register->has('houseNumber')) {
                                $user->getInfo()->setHouseNumber($register->get('houseNumber')->getValue());
                            }
                            if ($register->has('phone')) {
                                $user->getInfo()->setPhone($register->get('phone')->getValue());
                            }
                            if ($register->has('postalCode')) {
                                $user->getInfo()->setPostalCode($register->get('postalCode')->getValue());
                            }
                            if ($register->has('city')) {
                                $user->getInfo()->setCity($register->get('city')->getValue());
                            }
                            if ($register->has('street')) {
                                $user->getInfo()->setStreet($register->get('street')->getValue());
                            }
                            if ($register->has('gender')) {
                                $user->getInfo()->setGender($register->get('gender')->getValue());
                            }
                        }
                        $repositories->store($user);

                        if(User::ROLE_RECRUITER == $register->get('role')->getValue()) {
                            if ($register->has('organizationName')) {
                                $organizationName = $register->get('organizationName')->getValue();
                                /* @var \Organizations\Entity\Organization $organization */
                                $organization = $repositoriesOrganization->createWithName($organizationName);
                                $organization->setUser($user);

                                if ($register->has('postalCode') && is_object($organization)) {
                                    $organization->getContact()->setPostalcode($register->get('postalCode')->getValue());
                                }

                                if ($register->has('city') && is_object($organization)) {
                                    $organization->getContact()->setCity($register->get('city')->getValue());
                                }

                                if ($register->has('street')) {
                                    $organization->getContact()->setStreet($register->get('street')->getValue());
                                }

                                if ($register->has('houseNumber') && is_object($organization)) {
                                    $organization->getContact()->setHouseNumber($register->get('houseNumber')->getValue());
                                }

                                $permissions = $organization->getPermissions();
                                $permissions->grant($user, PermissionsInterface::PERMISSION_ALL);
                                $repositories->persist($organization);
                            }
                        }

                        $viewModel->setTemplate('registration\completed');

                        $this->notification()->success(
                            /*@translate*/ 'An Email with an activation link has been sent, please try to check your email box'
                        );
                        $logger->info('Mail first-login sent to ' . $user->getInfo()->getDisplayName() . ' (' . $email . ')');
                    } else {
                        // this branch is obsolete unless we do decide not to use an exception anymore, whenever something goes wrong with the user

                        $this->notification()->danger(
                            /*@translate*/ 'User can not be created'
                        );
                    }
                } catch (UserAlreadyExistsException $e) {

                    $this->notification()->danger(
                        /*@translate*/ 'User can not be created'
                    );

                    $this->notification()->info(
                        json_encode(
                            array('message' => /*@translate*/ 'user with this e-mail address already exists',
                                           'target' => 'register-email-errors')
                        )
                    );
                } catch (\Exception $e) {
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
