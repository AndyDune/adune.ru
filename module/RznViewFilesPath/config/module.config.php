<?php
/**
 * RznViewFilesPath Module (https://github.com/AndyDune/RznViewFilesPath)
 *
 * @link https://github.com/AndyDune/RznViewFilesPath for the canonical source repository
 * @license http://www.opensource.org/licenses/mit-license.php  MIT License
 */
return array(
    'rzn_view_files_path' => array(
        'view_files_theme'     => 'default',
        'view_files_base_path' => '/view/',
        'view_files_domain'    => null,
        'view_files_theme_service' => null
    ),

    'view_helpers' => array (
        'invokables' => array(
            'viewFilesPath' => 'RznViewFilesPath\View\Helper\ViewFilesPath',
        ),
        'aliases' => array(
            'viewFilePath' => 'viewFilesPath'
        )
    ),
);
