<?php
/**
 * For add logo and timezone
 * @package WordPress
 * @subpackage Administration
 */
 global $wpdb;
 $template_directory_url = get_template_directory_uri();
 $template_directory = get_template_directory();
 $table_name = $wpdb->prefix . "tpv_mixer";
 //echo "<pre>";print_r($_POST);exit;
 if(isset($_POST['tpvid'])){
    
    global $wpdb;
    $tpv_id = $_POST['tpvid'];
    if(isset($_POST['timezone_offset'])){
      $update="timezone='".$_POST['timezone_offset']."'";
    }
    if(isset($_POST['instructions'])){
      $update="instructions='".$_POST['instructions']."'";
    }
    if(isset($_POST['website'])){
      $update="website='".$_POST['website']."'";
    }
    if(isset($_POST['title'])){
      $update="title='".$_POST['title']."'";
    }
    if(isset($_POST['phone_no'])){
      $update="phone_no='".$_POST['phone_no']."'";
    }
    if(isset($_POST['ins_text'])){
      $update="instructions='".$_POST['ins_text']."'";
    }
    if(isset($_POST['background_colour'])){
      $update="background_colour='".$_POST['background_colour']."'";
    }
    if(isset($_POST['text_colour'])){
      $update="text_colour='".$_POST['text_colour']."'";
    }
    if(isset($_POST['text_font'])){
      $update="text_font='".$_POST['text_font']."'";
    }
    if(isset($_POST['pdf_header_text'])){
      $update="pdf_header_text='".$_POST['pdf_header_text']."'";
    }
    if(isset($_POST['colour_disclaimer'])){
      $update="colour_disclaimer='".$_POST['colour_disclaimer']."'";
    }
    if(isset($_POST['crop_data'])){

        $upload_dir   = wp_upload_dir();
        $url          = $upload_dir['baseurl']."/tpv_pdf_logo.jpg";
        $target_dir   = $upload_dir['basedir'];//.'/images/brand_logo/';//"uploads directory path";
        $target_file  = $target_dir ."/tpv_pdf_logo.jpg";
        //$output_file=
        if(file_put_contents($target_file, file_get_contents($_POST['crop_data']))){
           $update="url='".$url."'";
        }else{
          echo "Something went wrong";exit;
        }
    }
   
        $sql = "UPDATE $table_name set {$update} where tpv_id='{$tpv_id}'";
        $post_id = $wpdb->query($sql);
        $url=site_url()."/wp-admin/admin.php?page=tpv_colour_mixer";
        $url_new=site_url()."/wp-admin";
        //header("Location: $url");
        echo '<script>window.location="'.$url.'"</script>';
        //echo $sql;exit;
 }
 if(isset($_GET['id'])){
    global $wpdb;
    //echo "<pre>";print_r($_GET);exit;
        $tpv_id = $_GET['id'];
        $sql = "select * from $table_name where tpv_id='{$tpv_id}'";
    	  $post_id = $wpdb->get_results($sql);
    	  //echo "<pre>";print_r($post_id);
    	  $tid              = $post_id[0]->tpv_id;
        $logo_url         = $post_id[0]->url;
        $timezone         = $post_id[0]->timezone;
        $instructions     = $post_id[0]->instructions;
        $title            = $post_id[0]->title;
        $website          = $post_id[0]->website;
        $phone_no         = $post_id[0]->phone_no;
        $colour_disclaimer= $post_id[0]->colour_disclaimer;
        $pdf_header_text  = $post_id[0]->pdf_header_text;
        $text_colour      = $post_id[0]->text_colour;
        $background_colour= $post_id[0]->background_colour;
        $select_color     = $post_id[0]->select_color;
      
    //$phone_no     = $post_id[0]->phone_no;   
 }
 if(isset($_GET)){
    global $wpdb;
    //echo "<pre>";print_r($_GET);exit;
    if(isset($_GET['del'])){
     $tpv_id = $_GET['del'];
      if($tpv_id!=""){
       $sql = "delete from $table_name where tpv_id='{$tpv_id}'";
  	   $post_id = $wpdb->query($sql);
  	   $url=site_url()."/wp-admin/admin.php?page=tpv_colour_mixer";
  	   //header("Location: $url");
       //echo '<script>window.location="'.$url.'"</script>';
      }
   }  
 }
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}
#customers tr:nth-child(even){ background-color: #f2f2f2; }
#customers tr:hover { background-color: #ddd; }
#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
.tox-notification { display: none !important }
</style>
<script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<div class="row" style="margin-top:50px;margin-left:50px;"><h4>Edit Info</h4></div>
<?php
  if(isset($sucess_msg) && $sucess_msg !=""){
    	echo $sucess_msg;
  }
  if(isset($error_msg) && $error_msg !=""){
    	echo $error_msg;
  }
  $table_name = $wpdb->prefix . "tpv_mixer";		
	$sql = "select * from $table_name";
	$post_id = $wpdb->get_results($sql);
	//echo "<pre>";print_r($post_id);
	$tid = $post_id[0]->tpv_id;
	if($tid == 0){
  }else { 
  if($_GET['column']=='timezone'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label class="control-label col-sm-2" for="timezone-offset">Timezone</label>
      <div class="col-sm-4">
       <select name="timezone_offset" id="timezone-offset" class="form-control">
          <option <?php if($timezone=='Europe/London') { echo "selected";}?> value="Europe/London" >Europe/London</option>
          <option <?php if($timezone=='Pacific/Auckland') { echo "selected";}?> value="Pacific/Auckland">Pacific/Auckland</option>
          <option <?php if($timezone=='Australia/Sydney') { echo "selected";}?> value="Australia/Sydney">Australia/Sydney</option>
          <option <?php if($timezone=='America/Los_Angeles') { echo "selected";}?> value="America/Los_Angeles">America/Los Angeles</option>
          <option <?php if($timezone=='America/Toronto') { echo "selected";}?> value="America/Toronto">Canada/Toronto</option>
       </select>
       <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
     </div> 
    </div>
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
     <input type="submit" name="submit" value="submit" class="btn btn-default">
    </div>
   </div> 
  </form> 
<?php }
if($_GET['column']=='phone_no'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="phone_no" class="control-label col-sm-2">Phone Number</label>
      <div class="col-sm-4">
       <input type="number" name="phone_no" id="phone_no" value="<?php echo $phone_no; ?>" class="form-control" placeholder="Enter Phone Number">
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form> 
<?php }
if($_GET['column']=='website'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="phone_no" class="control-label col-sm-2">Website</label>
      <div class="col-sm-4">
       <input type="text" name="website" id="website" value="<?php echo $website; ?>" class="form-control" placeholder="Enter Website">
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form>
<?php }
if($_GET['column']=='text_colour'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="text_colour" class="control-label col-sm-2">Text Colour</label>
      <div class="col-sm-4">
       <input type="text" name="text_colour" id="text_colour" value="<?php echo $text_colour; ?>" class="form-control" placeholder="Enter Text Colour">
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form>

  
  

  <?php }
if($_GET['column']=='text_font'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="text_font" class="control-label col-sm-2">Font Family</label>
      <div class="col-sm-4">
       <select name="text_font" >>
        <option value="Arial, sans-serif" >Arial</option>
        <option value="Helvetica, sans-serif" >Helvetica</option>
        <option value="Verdana, sans-serif" >Verdana</option>
        <option value="Times New Roman">Times New Roman</option>
        <option value="Apple Chancery, cursive" > Apple </option>
        <option value="Snell Roundhand, cursive	" > Snell </option>
        <option value="Marker Felt, fantasy"  > Marker </option>
        <option value="Lucida Console, Courier New, monospace"> Lucida  </option>
       </select>
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
    <?php 
      //$text_font = $_POST['text_font'];
    ?>

  </form>
  



<?php }
if($_GET['column']=='pdf_header_text'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="pdf_header_text" class="control-label col-sm-2">PDF Header Text</label>
      <div class="col-sm-4">
       <input type="text" name="pdf_header_text" id="pdf_header_text" value="<?php echo $pdf_header_text; ?>" class="form-control" placeholder="Enter PDF Header Text">
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form>
  
  <?php }

  if($_GET['column'] == 'select_color'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="pdf_header_text" class="control-label col-sm-2">PDF Header Text</label>
      <div class="col-sm-4">
       <input type="text" name="pdf_header_text" id="pdf_header_text" value="<?php echo $pdf_header_text; ?>" class="form-control" placeholder="Enter PDF Header Text">
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form>




<?php }
if($_GET['column']=='colour_disclaimer'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="colour_disclaimer" class="control-label col-sm-2">Colour Disclaimer Text</label>
      <div class="col-sm-4">
       <!-- <input type="text" name="colour_disclaimer" id="colour_disclaimer" value="<?php echo $colour_disclaimer; ?>" class="form-control" placeholder="Enter Colour Disclaimer Text"> -->
       <textarea cols="50" rows="10" name="colour_disclaimer" id="colour_disclaimer" class="form-control" placeholder="Enter Colour Disclaimer Text"> <?php echo $colour_disclaimer; ?></textarea>
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form>
  
<?php }
if($_GET['column']=='background_colour'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="background_colour" class="control-label col-sm-2">Background Colour</label>
      <div class="col-sm-4">
       <input type="text" name="background_colour" id="background_colour" value="<?php echo $background_colour; ?>" class="form-control" placeholder="Enter Background Colour">
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form>
  
<?php }
if($_GET['column']=='title'){
  ?>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="title" class="control-label col-sm-2">Instruction Title</label>
      <div class="col-sm-4">
       <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="Enter Title">
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
       <input type="submit" name="submit" value="submit" class="btn btn-default">
      </div>
    </div> 
  </form>
  
<?php }
if($_GET['column']=='instructions'){
  ?>
  <script src="https://cdn.tiny.cloud/1/s6alf19vljawhapummqxy922ginsorwq4f2q1ipmpyytbujv/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <!-- <script>tinymce.init({selector:'textarea#ins_text',height: 400,width: 800});</script> -->
  <script>
    tinymce.init({
      selector: 'textarea#ins_text',height: 400,width: 800,
      plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable',
      menubar: 'file edit view insert format tools table tc help',
      toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
  </script>
  <form action="" method="post" name="edit_elements" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label for="phone_no" class="control-label col-sm-2">Instruction</label>
      <div class="col-sm-4">
       <textarea id="ins_text" name="ins_text" class="form-control" rows="5" placeholder="Enter instruction text"><?php echo $instructions; ?></textarea>
      </div>
      <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
    </div>  
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
     <input type="submit" name="submit" value="submit" class="btn btn-default">
    </div>
  </div> 
  </form> 
<?php }
if($_GET['column']=='url'){
  ?>
  <form action="" method="post" name="edit_elements" id="url_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
     <label class="control-label col-sm-2" for="upload_logo"></label>
     <div class="col-sm-4"> 
      <p>Prefer logo size width is 960 and height is 480</p>
     </div> 
    </div> 
    <div class="form-group">
     <!-- <label class="control-label col-sm-2" for="upload_logo">Upload Logo</label>
     <div class="col-sm-4"> 
      <input type="file" name="upload_logo" id="upload_logo" class="form-control"/>
     </div> -->
     <div class="col-sm-4"> 
        <label class="btn btn-primary btn_cntr" for="inputImage" title="Upload image file">Upload New Image
         <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
        </label>
      </div>
     <input type="hidden" name="tpvid" value="<?php echo $tid;?>" />
     <input type="hidden" name="crop_data" id="crop_data" value="" /> 
    </div>
    <div class="form-group">
     <label for="ins_text" class="control-label col-sm-2"></label>
      <div class="col-sm-4">  
        <!-- <input type="hidden" name="submit" value="submit" class="btn btn-default">  -->
      </div>
    </div> 
  </form>
<!-- Wrap the image or canvas element with a block element (container) -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.1.3/cropper.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.1.3/cropper.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" crossorigin="anonymous"></script> 
<!-- Content -->
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="img-container">
          <img src="<?php echo $logo_url;?>" alt="Picture">
        </div>
      </div>
      <div class="col-md-3">
        <div class="docs-data" style="display: none !important;">
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataX">X</label>
            <input type="text" class="form-control" id="dataX" placeholder="x">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataY">Y</label>
            <input type="text" class="form-control" id="dataY" placeholder="y">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataWidth">Width</label>
            <input type="text" class="form-control" id="dataWidth" placeholder="width">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataHeight">Height</label>
            <input type="text" class="form-control" id="dataHeight" placeholder="height">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataRotate">Rotate</label>
            <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
            <span class="input-group-addon">deg</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataScaleX">ScaleX</label>
            <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataScaleY">ScaleY</label>
            <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
          </div>
        </div>
      </div>
    </div>
    <div class="row" id="actions">
      <div class="col-md-9 docs-buttons">
        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
          </button>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
              <span class="fa fa-rotate-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
              <span class="fa fa-rotate-right"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
              <span class="fa fa-arrows-h"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
              <span class="fa fa-arrows-v"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
              <span class="fa fa-check"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
              <span class="fa fa-remove"></span>
            </span>
          </button>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
              <span class="fa fa-refresh"></span>
            </span>
          </button>
        </div>

        <div class="btn-group btn-group-crop">
          <button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas({ maxWidth: 4096, maxHeight: 4096 })">
              Save Logo
            </span>
          </button>
        </div>
        <button type="button" class="btn btn-primary" data-method="zoomTo" data-option="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoomTo(1)">
            Zoom to 100%
          </span>
        </button>
      </div>
      <div class="col-md-3 docs-toggles" style="display: none !important;">
        <!-- <h3>Toggles:</h3> -->
        <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
          <label class="btn btn-primary active">
            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">
              16:9
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
              4:3
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
              1:1
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
              2:3
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
              Free
            </span>
          </label>
        </div>

        <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
          <label class="btn btn-primary active">
            <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
              VM0
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              VM1
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
              VM2
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
              VM3
            </span>
          </label>
        </div>
        <div class="dropdown dropup docs-options">
          <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
            Toggle Options
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="toggleOptions">
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="responsive" checked>
                responsive
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="restore" checked>
                restore
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="checkCrossOrigin" checked>
                checkCrossOrigin
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="checkOrientation" checked>
                checkOrientation
              </label>
            </li>

            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="modal" checked>
                modal
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="guides" checked>
                guides
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="center" checked>
                center
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="highlight" checked>
                highlight
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="background" checked>
                background
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="autoCrop" checked>
                autoCrop
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="movable" checked>
                movable
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="rotatable" checked>
                rotatable
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="scalable" checked>
                scalable
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="zoomable" checked>
                zoomable
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="zoomOnTouch" checked>
                zoomOnTouch
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="zoomOnWheel" checked>
                zoomOnWheel
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="cropBoxMovable" checked>
                cropBoxMovable
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="cropBoxResizable" checked>
                cropBoxResizable
              </label>
            </li>
            <li class="dropdown-item">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="toggleDragModeOnDblclick" checked>
                toggleDragModeOnDblclick
              </label>
            </li>
          </ul>
        </div><!-- /.dropdown -->
      </div><!-- /.docs-toggles -->
    </div>
  </div>
  <script type="text/javascript">
    jQuery.noConflict();
    window.onload = function() {

    'use strict';

    var Cropper = window.Cropper;
    var URL = window.URL || window.webkitURL;
    var container = document.querySelector('.img-container');
    var image = container.getElementsByTagName('img').item(0);
    var download = document.getElementById('download');
    var actions = document.getElementById('actions');
    var dataX = document.getElementById('dataX');
    var dataY = document.getElementById('dataY');
    var dataHeight = document.getElementById('dataHeight');
    var dataWidth = document.getElementById('dataWidth');
    var dataRotate = document.getElementById('dataRotate');
    var dataScaleX = document.getElementById('dataScaleX');
    var dataScaleY = document.getElementById('dataScaleY');
    var options = {
    aspectRatio: 2/1,
    preview: '.img-preview',
    ready: function(e) {
      console.log(e.type);
    },
    cropstart: function(e) {
      console.log(e.type, e.detail.action);
    },
    cropmove: function(e) {
      console.log(e.type, e.detail.action);
    },
    cropend: function(e) {
      console.log(e.type, e.detail.action);
    },
    crop: function(e) {
      var data = e.detail;

      console.log(e.type);
      dataX.value = Math.round(data.x);
      dataY.value = Math.round(data.y);
      dataHeight.value = Math.round(data.height);
      dataWidth.value = Math.round(data.width);
      dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
      dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
      dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';
    },
    zoom: function(e) {
      console.log(e.type, e.detail.ratio);
    }
  };
  var cropper = new Cropper(image, options);
  var originalImageURL = image.src;
  var uploadedImageType = 'image/jpeg';
  var uploadedImageURL;

  // Tooltip
  //$('[data-toggle="tooltip"]').tooltip();

  // Buttons
  if (!document.createElement('canvas').getContext) {
    $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
  }

  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  }

  // Download
/*  if (typeof download.download === 'undefined') {
    download.className += ' disabled';
  }*/

  // Options
  actions.querySelector('.docs-toggles').onchange = function(event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var cropBoxData;
    var canvasData;
    var isCheckbox;
    var isRadio;

    if (!cropper) {
      return;
    }

    if (target.tagName.toLowerCase() === 'label') {
      target = target.querySelector('input');
    }

    isCheckbox = target.type === 'checkbox';
    isRadio = target.type === 'radio';

    if (isCheckbox || isRadio) {
      if (isCheckbox) {
        options[target.name] = target.checked;
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();

        options.ready = function() {
          console.log('ready');
          cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        };
      } else {
        options[target.name] = target.value;
        options.ready = function() {
          console.log('ready');
        };
      }

      // Restart
      cropper.destroy();
      cropper = new Cropper(image, options);
    }
  };

  // Methods
  actions.querySelector('.docs-buttons').onclick = function(event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var cropped;
    var result;
    var input;
    var data;

    if (!cropper) {
      return;
    }

    while (target !== this) {
      if (target.getAttribute('data-method')) {
        break;
      }

      target = target.parentNode;
    }

    if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
      return;
    }

    data = {
      method: target.getAttribute('data-method'),
      target: target.getAttribute('data-target'),
      option: target.getAttribute('data-option') || undefined,
      secondOption: target.getAttribute('data-second-option') || undefined
    };

    cropped = cropper.cropped;

    if (data.method) {
      if (typeof data.target !== 'undefined') {
        input = document.querySelector(data.target);

        if (!target.hasAttribute('data-option') && data.target && input) {
          try {
            data.option = JSON.parse(input.value);
          } catch (e) {
            console.log(e.message);
          }
        }
      }

      switch (data.method) {
        case 'rotate':
          if (cropped) {
            cropper.clear();
          }

          break;

        case 'getCroppedCanvas':
          try {
            data.option = JSON.parse(data.option);
          } catch (e) {
            console.log(e.message);
          }

          if (uploadedImageType === 'image/jpeg') {
            if (!data.option) {
              data.option = {};
            }

            data.option.fillColor = '#fff';
          }

          break;
      }

      result = cropper[data.method](data.option, data.secondOption);

      switch (data.method) {
        case 'rotate':
          if (cropped) {
            cropper.crop();
          }

          break;

        case 'scaleX':
        case 'scaleY':
          target.setAttribute('data-option', -data.option);
          break;

        case 'getCroppedCanvas':
          if (result) {
            // Bootstrap's Modal
            //$('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
            console.log(result);
            console.log(result.toDataURL(uploadedImageType));
            jQuery("#crop_data").val(result.toDataURL(uploadedImageType));
            jQuery("#url_form").submit();
            //if (!download.disabled) {
            //  download.href = result.toDataURL(uploadedImageType);
            //}
          }

          break;

        case 'destroy':
          cropper = null;

          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
            uploadedImageURL = '';
            image.src = originalImageURL;
          }

          break;
      }

      if (typeof result === 'object' && result !== cropper && input) {
        try {
          input.value = JSON.stringify(result);
        } catch (e) {
          console.log(e.message);
        }
      }
    }
  };

  document.body.onkeydown = function(event) {
    var e = event || window.event;

    if (!cropper || this.scrollTop > 300) {
      return;
    }

    switch (e.keyCode) {
      case 37:
        e.preventDefault();
        cropper.move(-1, 0);
        break;

      case 38:
        e.preventDefault();
        cropper.move(0, -1);
        break;

      case 39:
        e.preventDefault();
        cropper.move(1, 0);
        break;

      case 40:
        e.preventDefault();
        cropper.move(0, 1);
        break;
    }
  };

  // Import image
  var inputImage = document.getElementById('inputImage');

  if (URL) {
    inputImage.onchange = function() {
      var files = this.files;
      var file;

      if (cropper && files && files.length) {
        file = files[0];

        if (/^image\/\w+/.test(file.type)) {
          uploadedImageType = file.type;

          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
          }

          image.src = uploadedImageURL = URL.createObjectURL(file);
          cropper.destroy();
          cropper = new Cropper(image, options);
          inputImage.value = null;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImage.disabled = true;
    inputImage.parentNode.className += ' disabled';
  }
};
</script>
<style type="text/css">

.btn {
  padding-left: .75rem;
  padding-right: .75rem;
}
.btn_cntr {
  margin-left: 54%;
}
label.btn {
  margin-bottom: 0;
}

.d-flex > .btn {
  flex: 1;
}
.carbonads {
  border-radius: .25rem;
  border: 1px solid #ccc;
  font-size: .875rem;
  overflow: hidden;
  padding: 1rem;
}
.carbon-wrap {
  overflow: hidden;
}
.carbon-img {
  clear: left;
  display: block;
  float: left;
}
.carbon-text,
.carbon-poweredby {
  display: block;
  margin-left: 140px;
}
.carbon-text,
.carbon-text:hover,
.carbon-text:focus {
  color: #fff;
  text-decoration: none;
}
.carbon-poweredby,
.carbon-poweredby:hover,
.carbon-poweredby:focus {
  color: #ddd;
  text-decoration: none;
}
@media (min-width: 768px) {
  .carbonads {
    float: right;
    margin-bottom: -1rem;
    margin-top: -1rem;
    max-width: 360px;
  }
}
.footer {
  font-size: .875rem;
}
.heart {
  color: #ddd;
  display: block;
  height: 2rem;
  line-height: 2rem;
  margin-bottom: 0;
  margin-top: 1rem;
  position: relative;
  text-align: center;
  width: 100%;
}
.heart:hover {
  color: #ff4136;
}
.heart::before {
  border-top: 1px solid #eee;
  content: " ";
  display: block;
  height: 0;
  left: 0;
  position: absolute;
  right: 0;
  top: 50%;
}
.heart::after {
  background-color: #fff;
  content: "♥";
  padding-left: .5rem;
  padding-right: .5rem;
  position: relative;
  z-index: 1;
}
.img-container,
.img-preview {
  background-color: #f7f7f7;
  text-align: center;
  width: 100%;
}
.img-container {
  margin-bottom: 1rem;
  max-height: 497px;
  min-height: 200px;
}

@media (min-width: 768px) {
  .img-container {
    min-height: 497px;
  }
}

.img-container > img {
  max-width: 100%;
}

.docs-preview {
  margin-right: -1rem;
}

.img-preview {
  float: left;
  margin-bottom: .5rem;
  margin-right: .5rem;
  overflow: hidden;
}

.img-preview > img {
  max-width: 100%;
}

.preview-lg {
  height: 9rem;
  width: 16rem;
}

.preview-md {
  height: 4.5rem;
  width: 8rem;
}

.preview-sm {
  height: 2.25rem;
  width: 4rem;
}

.preview-xs {
  height: 1.125rem;
  margin-right: 0;
  width: 2rem;
}

.docs-data > .input-group {
  margin-bottom: .5rem;
}

.docs-data > .input-group > label {
  justify-content: center;
  min-width: 5rem;
}

.docs-data > .input-group > span {
  justify-content: center;
  min-width: 3rem;
}

.docs-buttons > .btn,
.docs-buttons > .btn-group,
.docs-buttons > .form-control {
  margin-bottom: .5rem;
  margin-right: .25rem;
}

.docs-toggles > .btn,
.docs-toggles > .btn-group,
.docs-toggles > .dropdown {
  margin-bottom: .5rem;
}

.docs-tooltip {
  display: block;
  margin: -.5rem -.75rem;
  padding: .5rem .75rem;
}

.docs-tooltip > .icon {
  margin: 0 -.25rem;
  vertical-align: top;
}

.tooltip-inner {
  white-space: normal;
}

.btn-upload .tooltip-inner,
.btn-toggle .tooltip-inner {
  white-space: nowrap;
}

.btn-toggle {
  padding: .5rem;
}

.btn-toggle > .docs-tooltip {
  margin: -.5rem;
  padding: .5rem;
}

@media (max-width: 400px) {
  .btn-group-crop {
    margin-right: -1rem!important;
  }
  .btn-group-crop > .btn {
    padding-left: .5rem;
    padding-right: .5rem;
  }
  .btn-group-crop .docs-tooltip {
    margin-left: -.5rem;
    margin-right: -.5rem;
    padding-left: .5rem;
    padding-right: .5rem;
  }
}

.docs-options .dropdown-menu {
  width: 100%;
}

.docs-options .dropdown-menu > li {
  font-size: .875rem;
  padding-left: 1rem;
  padding-right: 1rem;
}

.docs-options .dropdown-menu > li:hover {
  background-color: #f7f7f7;
}

.docs-options .dropdown-menu > li > label {
  display: block;
}

.docs-cropped .modal-body {
  text-align: center;
}

.docs-cropped .modal-body > img,
.docs-cropped .modal-body > canvas {
  max-width: 100%;
}

  </style>
<?php
  } 
}
?>