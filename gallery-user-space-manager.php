<?php

/**
 * Plugin Name: BP Gallery User Space Manager
 * Version:1.0
 * Author: Brajesh Singh
 * PLugin URI: http://buddydev.com
 * Description: Allows to to manage space for individual users while using Bp Gallery
 */
class BpGalleryCustomUserSpaceManager{
    private static $instance;
    private function __construct(){
        //show settings
        add_action('personal_options',array($this,'show_settings'));
        //save
        add_action('edit_user_profile_update',array($this,'save_settings'));
    }
    
    public static function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        
        return self::$instance;
    }
    
   
function show_settings(){
    global $user_id;
    //find if this user was allocated some space earlier
    $allocated=  get_user_meta($user_id, 'gallery_upload_space', true);
    if(empty($allocated))
        $allocated='';//we don't want to give admin a wrong impression that the limit is set to zero
        
   $global_allocated=get_site_option('gallery_upload_space'); 
   
   ;
    ?>
 <tr class='bp-gallery-user-allocated-space''>
     <th scope='row'><label for='bp_gallery_user_space'> <?php _e('Maximum Allowed Gallery Space')?></label></th>
    <td> <input value="<?php echo $allocated;?>" type='text' name='bp_gallery_user_space' id='bp_gallery_user_space'/> MB
    <br /><?php if(empty($allocated)):?>Currently you haven't set custom space for this user. The current space limit is governed by global settings of gallery(<?php echo $global_allocated;?> MB).<?php endif;?></td>
 </tr>
    
<?php }



function save_settings($user_id){
  if(!is_super_admin())
      return;
  $option=$_POST['bp_gallery_user_space'];
  if(!empty($option)&&  is_numeric($option))
      update_user_meta ($user_id, 'gallery_upload_space', $option);
  
}

 
}

//end of class
//initialize
BpGalleryCustomUserSpaceManager::get_instance();
?>