<?php echo form_open('admin/search'); ?>
		<div>
			<?php echo form_label('Name:', 'name'); ?>
			<?php echo form_input('name', set_value('name'), 'id="name"'); ?>
		</div>
	
		<div>
			<?php echo form_label('Category:', 'category'); ?>
			<?php echo form_dropdown('category', $Category_table_category_options, 
				set_value('category'), 'id="category"'); ?>
		</div>
		
		<div>
			<?php echo form_label('Brand:', 'brand'); ?>
			<?php echo form_dropdown('brand', $Brand_table_category_options, 
				set_value('brand'), 'id="brand"'); ?>
		</div>
		
	
		<div>
			<?php echo form_label('Price:', 'price'); ?>
			<?php echo form_dropdown('price_comparison', 
				array('gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<') , 
				set_value('price_comparison'), 'id="price_comparison"'); ?>
			<?php echo form_input('price', set_value('price'), 'id="price"'); ?>
		</div>
		
		<div>
			<?php echo form_label('Quantity:', 'quantity'); ?>
			<?php echo form_dropdown('quantity_comparison', 
				array('gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<') , 
				set_value('quantity_comparison'), 'id="quantity_comparison"'); ?>
			<?php echo form_input('quantity', set_value('quantity'), 'id="quantity"'); ?>
		</div>
		
		<div>
			<?php echo form_submit('action', 'Search'); ?>
		</div>
	
	<?php echo form_close(); ?>
	
	<div>
		Found <?php echo $num_results; ?> items
	</div>
<div id="inventory_table">
	<?php $headings = array();
		foreach($fields as $field_name => $field_display): ?>
			<?php
				$str = ""; 
				//if ($sort_by == $field_name)$str .= "class=\"sort_$sort_order\""; 
						$str .= anchor("admin/index/$field_name/" .
					(($sort_order == 'asc' && $sort_by == $field_name) ? 'desc' : 'asc'),
					$field_display); array_push($headings, $str); ?>
			<?php endforeach; ?>
	<?php $this->table->set_heading($headings); ?>
    <?php if($num_results > 0){ 
    		foreach($records as $record){
       			 $this->table->add_row('<img src = "'.site_url().$record->image.'"/>', $record->name, $record->brand, 
                            $record->category, $record->price,
                            $record->quantity, $record->description);
        	}
		}
        $this->table->set_caption('Current invetory');;
         ?>
    <?php echo $this->table->generate(); ?>
	<?php echo $this->pagination->create_links(); ?>
	<?php echo form_open_multipart('admin/upload_csv');?>
	<?php echo form_upload('CSV', 'inventory.csv');?>
	<?php echo form_submit('submit','upload');?>
	<?php echo form_close();?>
	<?php  print_r($test); ?>	
</div>
