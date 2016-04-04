<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">권한 관리 &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h3>
					<div class="clearfix"></div>
				</div>
				
				<div class="col-separator-h"></div>
                
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="list-inline">
                            <li>
                                <select id="pem-type" class="form-control">
                                <?php foreach($this->data['permissions'] as $permission) : ?>
                                    <option 
                                        value="<?php echo $permission->id; ?>"
                                        <?php echo  $permission->id == $this->data['permission']->id ? 'selected' : ''; ?>
                                    >
                                        <?php echo $permission->name; ?>
                                    </option>
                                <?php endforeach; ?>
                                </select>
                            </li>
                            <li>
                                <button
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#modal-permission"
                                    data-whatever="@twbootstrap">
                                    새로운 권한 생성
                                </button>
                                <button id="pem_save" class="btn btn-success"> 변경사항 저장 </button>
                                <button id="pem_delete" class="btn btn-warning"> 삭제 </button>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
<!-- Table -->
<table class="footable table table-striped table-primary">

    <!-- Table heading -->
    <thead>
        <tr>
            <th data-class="expand">카테고리명</th>
            <th data-class="expand">메뉴명</th>
            <th data-class="expand">권한 ON / OFF</th>
        </tr>
    </thead>
    <!-- // Table heading END -->
    
    <!-- Table body -->
    <tbody id="site-list">
        <?php foreach($this->data['menus'] as $menu) : ?>
        <?php 
            $for_count = count($menu->sub) == 0 ? count($menu->sub)+1 : count($menu->sub);
            $pem_ids = explode(',', $this->data['permission']->menu_ids);
            for($i=0; $i<$for_count; $i++) : 
        ?>
        <tr data-pid="<?php echo isset($menu->sub[$i]) ? $menu->sub[$i]->id : $menu->id; ?>">
            <td><?php echo $menu->name; ?></td>
            <td><?php echo isset($menu->sub[$i]) ? $menu->sub[$i]->name : $menu->name; ?></td>
            <td>
                <?php 
                    $pem = FALSE;
                    $find = isset($menu->sub[$i]) ? $menu->sub[$i]->id : $menu->id;
                    
                    foreach($pem_ids as $k => $v) {
                        if($v == $find) {
                            $pem = TRUE;
                            break;
                        }
                    }
                    
                    echo $pem 
                        ? '<input name="pem_chk" type="checkbox" checked />' 
                        : '<input name="pem_chk" type="checkbox" />';
                ?>
            </td>
        </tr>
        <?php endfor; ?>
        <?php endforeach; ?>
    </tbody>
    <!-- // Table body END -->
    
</table>
<!-- // Table END -->
<!-- Modal -->
<div class="modal fade" id="modal-permission">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal heading -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">새로운 권한 생성</h3>
			</div>
			<!-- // Modal heading END -->
            <form 
                role="form" 
                method="POST"
                action="<?php echo base_url('admin/create_permission') ?>"
            >
                <input id="csrf_token" type="hidden" 
                    name="<?=$this->security->get_csrf_token_name()?>" 
                    value="<?=$this->security->get_csrf_hash()?>" />
                <!-- Modal body -->
                <div class="modal-body">
                    <p id="msg">새로 만들 권한의 이름을 적어주세요.</p>
                    <input type="text" name="name" />
                </div>
                <!-- // Modal body END -->
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">닫기</a> 
                    <button id='btn-submit' class="btn btn-primary">생성</button>
                </div>
                <!-- // Modal footer END -->
            </form>
		</div>
	</div>
</div>
<!-- // Modal END -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
