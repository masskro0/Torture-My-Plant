<?php
/*
 * This script simply contains all errors that were made when a user entered information in a html form. It displays
 * always the first error so the screen wouldn't be overloaded. HTML class: "error"
 */

// Check if the error array contains any content. If yes then display the first string
if (count($errors) > 0){ ?>
  <div class="error">
  	  <p><?php echo $errors[0]; ?></p>
  </div>
<?php } ?>
