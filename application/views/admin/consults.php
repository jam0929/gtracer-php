<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">사이트 관리 &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h3>
					<div class="clearfix"></div>
				</div>
				
				<div class="col-separator-h"></div>
                
                <div class="row">
                    <div class="col-xs-12">
                    <form role="form" action="<?php echo base_url('admin/consults-user-search') ?>" method="POST">
                        <input id="csrf_token" type="hidden" 
                            name="<?=$this->security->get_csrf_token_name()?>" 
                            value="<?=$this->security->get_csrf_hash()?>" />
                        <ul class="list-inline">
                            <li>
                                <select name="type" class="form-control">
                                    <option value="username">아이디</option>
                                    <option value="email">이메일</option>
                                </select>
                            </li>
                            <li>
                                <input type="text" name="value" class="form-control">
                            </li>
                            <li>
                                <input type="submit" class="btn btn-primary" value="검색"/>
                            </li>
                        </ul>
                    </form>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                    
<!-- Table -->
		<table class="footable table table-striped table-primary">

			<!-- Table heading -->
			<thead>
				<tr>
					<th data-class="expand">소유자</th>
					<th data-class="expand">계정</th>
					<th data-class="expand">속성</th>
					<th data-class="expand">보기</th>
					<th data-class="expand">보고서 관리</th>
				</tr>
			</thead>
			<!-- // Table heading END -->
			
			<!-- Table body -->
			<tbody id="site-list">
                <?php foreach($this->data['sites'] as $site) : ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url('admin/consults/'.$site->user_id) ?>">
                            <?php echo $site->username; ?>
                        </a>
                    </td>
                    <td><?php echo $site->account_name; ?></td>
                    <td><?php echo $site->property_name; ?></td>
                    <td><?php echo $site->profile_name; ?></td>
                    <td>
                        <button 
                            class="btn btn-success btn-xs" 
                            data-toggle="modal" 
                            data-target="#modal-sites" 
                            data-dialog-type="add-date"
                            data-form-type="activate"
                            data-sid="<?php echo $site->id; ?>"
                            data-whatever="@twbootstrap">
                            보고서 관리
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
			</tbody>
			<!-- // Table body END -->
			
		</table>
		<!-- // Table END -->
        
        <?php echo $this->pagination->create_links(); ?>
        
<!-- Modal -->
<div class="modal fade" id="modal-sites">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal heading -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">사이트 활성화 요청</h3>
			</div>
			<!-- // Modal heading END -->
            
            <form 
                role="form" 
                action="<?php echo base_url('admin/ajax-site-status-change') ?>" 
                class="for-activate"
            >
                <input id="csrf_token" type="hidden" 
                    name="<?=$this->security->get_csrf_token_name()?>" 
                    value="<?=$this->security->get_csrf_hash()?>" />
                <input id="sid" type="hidden" name="sid" value="" />
                <input 
                    id="activate-date" 
                    type="hidden" 
                    name="activate-date" 
                    value="" 
                />
                <input id="status" type="hidden" name="status" value="" />
                <!-- Modal body -->
                <div class="modal-body">
                    <p id="msg"></p>
                    
                    <!-- 캘린더 추가 -->
                    <div id="datepicker-inline"></div>
                </div>
                <!-- // Modal body END -->
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">닫기</a> 
                    <button id='btn-submit' class="btn btn-primary">저장</button>
                </div>
                <!-- // Modal footer END -->
            </form>
		</div>
	</div>
</div>
<!-- // Modal END -->
                    </div>
                </div>
                <input id="csrf_token" type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
            </div>
        </div>
    </div>
</div>
