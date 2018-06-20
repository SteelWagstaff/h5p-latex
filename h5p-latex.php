<?php
/**
 * VM04 - H5P - LATEX PLUGIN
 *
 * Alters the way the H5P plugin works.
 *
 * @package   H5P
 * @author    VM04 <vm04.kolleg@lists.uni-hamburg.de>
 * @license   MIT
 * @link      https://www.universitaetskolleg.uni-hamburg.de/studieninteressierte/selbsteinschaetzung.html
 * @copyright 2017 - VM04
 *
 * @wordpress-plugin
 * Plugin Name:       H5P - LATEX PLUGIN
 * Plugin URI:        http://h5p.org/
 * Description:       Add latex support for the H5P module 
 * Version:           0.0.2
 * Author:            VM04
 * Author URI:        https://www.universitaetskolleg.uni-hamburg.de/studieninteressierte/selbsteinschaetzung.html
 * Text Domain:       h5p-latex
 * License:           MIT
 * License URI:       http://opensource.org/licenses/MIT
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}



/**
 * Implementation of hook_h5p_semantics_alter().
 *
 * Adds mathml tags to wysiwyg fields.
 */

function h5pmathjax_h5p_semantics_alter(&$semantics, $name, $majorVersion, $minorVersion) {
  
  foreach ($semantics as $field) {
    // Lists specify the field inside the list.
    while ($field->type === 'list') {
      $field = $field->field;
    }
 
    if ($field->type === 'group') {
      h5pmathjax_h5p_semantics_alter($field->fields);
    }
    else if ($field->type === 'text' && isset($field->widget) && $field->widget === 'html') {
      if (!isset($field->tags)) {
        $field->tags = array();
      }

 
      // Add MathML tags
      $field->tags = array_merge($field->tags, array(

        'math',
        'maction',
        'maligngroup',
        'malignmark',
        'menclose',
        'merror',
        'mfenced',
        'mfrac',
        'mglyph',
        'mi',
        'mlabeledtr',
        'mlongdiv',
        'mmultiscripts',
        'mn',
        'mo',
        'mover',
        'mpadded',
        'mphantom',
        'mroot',
        'mrow',
        'ms',
        'mscarries',
        'mscarry',
        'msgroup',
        'msline',
        'mspace',
        'msqrt',
        'msrow',
        'mstack',
        'mstyle',
        'msub',
        'msup',
        'msubsup',
        'mtable',
        'mtd',
        'mtext',
        'mtr',
        'munder',
        'munderover',
        'semantics',
        'annotation',
        'annotation-xml',
      ));
    }
  }
}
add_action('h5p_alter_library_semantics', 'h5pmathjax_h5p_semantics_alter');



/**
 * Allows you to alter which JavaScripts are loaded for H5P. This is
 * useful for adding your own custom scripts or replacing existing once.
 *
 * In this example we're going add a custom script which keeps track of the
 * scoring for drag 'n drop tasks.
 *
 * @param object &$scripts List of JavaScripts that will be loaded.
 * @param array $libraries The libraries which the scripts belong to.
 * @param string $embed_type Possible values are: div, iframe, external, editor.
 */
function h5pmods_include_latex(&$scripts, $libraries, $embed_type) {

  $scripts[] = (object) array(
    'path' => 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS_CHTML',
    'version' => '', //?ver=1
  );
  
}
add_action('h5p_alter_library_scripts', 'h5pmods_include_latex', 10, 3);

?>
