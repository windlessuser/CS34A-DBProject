<div id="inventory_table">
	<?php $this->table->set_heading('','Name','Brand','Category','Price','Quantity','Description'); ?>
    <?php foreach($records as $record){
        $this->table->add_row(site_url().$record->image,$record->name, $record->Brand, 
                            $record->category, $record->price,
                            $record->quantiry, $record->description);
        }
        $this->table->set_caption('Current invetory');
        $this->table->function = 'htmlspecialchars'; ?>
    <?php echo $this->table->generate(); ?>
	<?php echo $this->pagination->create_links(); ?>
	<?php echo form_open_multipart('admin/upload_csv');?>
	<?php echo form_upload('CSV', 'inventory.csv');?>
	<?php echo form_submit('submit','upload');?>
	<?php echo form_close();?>	
</div>
