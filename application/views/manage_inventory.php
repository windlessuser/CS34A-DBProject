<div id="inventory_table">
	<?php echo $this->table->generate($records); ?>
	<?php echo $this->pagination->create_links(); ?>
	<?php echo form_open_multipart('admin/upload_csv');?>
	<?php echo form_upload('CSV', 'inventory.csv');?>
	<?php echo form_submit('submit','upload');?>
	<?php echo form_close();?>
	<?php ?>
	
</div>
