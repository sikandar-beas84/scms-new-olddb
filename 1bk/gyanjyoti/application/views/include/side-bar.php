<!--aside open-->
<style>
    .user-info h5 {
    color: #0d6efd !important;
}
.side-menu .slide a {
    color: #ffffff !important;
}
</style>
<aside class="app-sidebar">
	<div class="app-sidebar__logo">
		<a class="header-brand" href="<?= base_url() ?>">
			<img src="<?=bs();?>assets/font-end/images/logo.png" class="header-brand"> 
			<h5>GPS</h5>
		</a>
	</div>
	<div class="app-sidebar3">

	
		<ul class="side-menu custom-ul">
			<?php
			$show_field = 'is_show_'.getUserType();
			$group = $this->Common_model->getAllData('groups', '', '', ['show_on_menu' => '1', 'is_active' => 'Y', $show_field => 'Y']);
			foreach($group as $key => $group_value):
				// if(hasGroupPrivilege($this->session->userdata('user_id'), $group_value->group_name)):
			?>
			<li class="slide">
				<a class="side-menu__item" <?php if($group_value->has_child == 'Y'): ?> data-bs-toggle="slide" <?php endif; ?> href="<?= base_url($group_value->link) ?>">
					<?= $group_value->icon ?>
					<span class="side-menu__label"><?= $group_value->group_name ?></span>
					<?php if($group_value->has_child == 'Y'): ?><i class="angle fa fa-angle-right"></i><?php endif; ?>
				</a>
				<?php if($group_value->has_child == 'Y'): ?>
				<ul class="slide-menu custom-ul">
					<?php 
					$sub_group = $this->Common_model->getAllData('sub_groups', '', '', ['group_id' => $group_value->id, 'show_on_menu' => '1', 'is_active' => 'Y', $show_field => 'Y']);
					foreach($sub_group as $k => $sub_group_value):
						// if(hasSubGroupPrivilege($this->session->userdata('user_id'), $sub_group_value->sub_group_name)):
					?>
					<li><a href="<?= base_url($sub_group_value->link) ?>" class="slide-item"><i class="fa fa fa-angle-right" style="margin-right: 7px;"></i> <?= $sub_group_value->sub_group_name ?></a></li>
					<?php 
						// endif;
					endforeach;?>
				</ul>
				<?php endif; ?>
			</li>
			<?php 
				// endif;
			endforeach;?>

		</ul>
		<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
			<a class="open-toggle" href="#">
				<i class="fa fa-arrow-left"></i>
			</a>
			<a class="close-toggle" href="#">
				<i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</div>
</aside>
<!--aside closed-->
