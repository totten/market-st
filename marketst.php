<?php

require_once 'marketst.civix.php';
// phpcs:disable
use CRM_Marketst_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_alterBundle().
 */
function marketst_civicrm_alterBundle(CRM_Core_Resources_Bundle $bundle) {
  $theme = Civi::service('themes')->getActiveThemeKey();
  switch ($theme . ':' . $bundle->name) {
    case 'marketst:bootstrap3':
      $bundle->clear();
      $bundle->addStyleFile('marketst', 'dist/bootstrap3.css');
      $bundle->addScriptFile('marketst', 'extern/bootstrap3/assets/javascripts/bootstrap.min.js', [
        'translate' => FALSE,
      ]);
      break;

    case 'marketst:bootstrap4':
      $bundle->clear();
      $bundle->addStyleFile('marketst', 'dist/bootstrap4.css');
      $bundle->addScriptFile('marketst', 'extern/bootstrap4/dist/js/bootstrap.min.js', [
        'translate' => FALSE,
      ]);
      break;

    case 'marketst:bootstrap5':
      $bundle->clear();
      $bundle->addStyleFile('marketst', 'dist/bootstrap5.css');
      $bundle->addScriptFile('marketst', 'extern/bootstrap5/dist/js/bootstrap.min.js', [
        'translate' => FALSE,
      ]);
      break;
  }
}

/**
 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
 */
function marketst_civicrm_container($container) {
  // At time of writing, only `bootstrap3` is defined in core. We're trying
  // to demonstrate an extreme case where all versions exist
  $container->addResource(new \Symfony\Component\Config\Resource\FileResource(__FILE__));
  foreach (['bootstrap4', 'bootstrap5'] as $bundleName) {
    $svcName = "bundle.{$bundleName}";
    if ($container->hasDefinition($svcName)) {
      continue;
    }

    $container->setDefinition($svcName, new \Symfony\Component\DependencyInjection\Definition('CRM_Core_Resources_Bundle', [$bundleName]))
      ->setFactory('_marketst_create_bundle')->setArguments([$bundleName])->setPublic(TRUE);
  }
}

/**
 * @param string $name
 * @return \CRM_Core_Resources_Bundle
 */
function _marketst_create_bundle($name) {
  $bundle = new CRM_Core_Resources_Bundle($name,
    ['script', 'scriptFile', 'scriptUrl', 'settings', 'style', 'styleFile', 'styleUrl', 'markup']);

  CRM_Utils_Hook::alterBundle($bundle);

  $bundle->filter(function ($s) {
    if ($s['type'] !== 'settings' && !isset($s['region'])) {
      $s['region'] = CRM_Core_Resources_Common::REGION;
    }
    return $s;
  });

  return $bundle;
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function marketst_civicrm_config(&$config) {
  _marketst_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function marketst_civicrm_xmlMenu(&$files) {
  _marketst_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function marketst_civicrm_install() {
  _marketst_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function marketst_civicrm_postInstall() {
  _marketst_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function marketst_civicrm_uninstall() {
  _marketst_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function marketst_civicrm_enable() {
  _marketst_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function marketst_civicrm_disable() {
  _marketst_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function marketst_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _marketst_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function marketst_civicrm_managed(&$entities) {
  _marketst_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function marketst_civicrm_caseTypes(&$caseTypes) {
  _marketst_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function marketst_civicrm_angularModules(&$angularModules) {
  _marketst_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function marketst_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _marketst_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function marketst_civicrm_entityTypes(&$entityTypes) {
  _marketst_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function marketst_civicrm_themes(&$themes) {
  // _marketst_civix_civicrm_themes($themes);
  $themes['marketst'] = [
    'ext' => 'marketst',
    'title' => '(Theme) Market Street',
    'help' => ts('Twitter look-and-feel'),
  ];

}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function marketst_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function marketst_civicrm_navigationMenu(&$menu) {
//  _marketst_civix_insert_navigation_menu($menu, 'Mailings', array(
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ));
//  _marketst_civix_navigationMenu($menu);
//}
