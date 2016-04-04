<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">사이트 관리 &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h3>
					
                    <div class="btn-group pull-right">
						<a href="dashboard_analytics.html" class="btn btn-primary disabled">
                            <!-- 추가 결제 -->
                            <i class="fa fa-fw fa-bar-chart-o"></i> 활성화 사이트 <?php echo count($this->data['activatedSites']); ?> 개
                        </a>
                        <a href="#" class="btn btn-primary btn-google site-update">
                            <i class="fa fa-fw fa-bar-chart-o"></i> 사이트 정보 업데이트
                        </a>
                        <a href="#" class="btn btn-primary btn-google connection">
                            <i class="fa fa-fw fa-bar-chart-o"></i> 구글 계정 연동
                        </a>
                        <a 
                            href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo current_url(); ?>" 
                            class="btn btn-primary btn-google logout">
                            <i class="fa fa-fw fa-bar-chart-o"></i> 구글 계정 로그 아웃
                        </a>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="col-separator-h"></div>
                
                <div class="row">
                    <div class="col-xs-12">
                    
<!-- Table -->
		<table class="footable table table-striped table-primary">

			<!-- Table heading -->
			<thead>
				<tr>
					<th data-class="expand">계정</th>
					<th data-class="expand">속성</th>
					<th data-class="expand">보기</th>
					<th data-class="expand">활성화</th>
					<th data-hide="phone,tablet">기본값</th>
				</tr>
			</thead>
			<!-- // Table heading END -->
			
			<!-- Table body -->
			<tbody id="site-list">
                <?php foreach($this->data['sites'] as $site) : ?>
                <tr 
                    data-sid="<?php echo $site->id; ?>"
                    data-status="<?php echo $site->status; ?>"
                >
                    <td><?php echo $site->account_name; ?></td>
                    <td><?php echo $site->property_name; ?></td>
                    <td><?php echo $site->profile_name; ?></td>
                    <td>
                        <?php if($site->status == 'NOT ACTIVATED') : ?>
                            <button 
                                class="btn btn-primary btn-xs" 
                                data-toggle="modal" 
                                data-target="#modal-change" 
                                data-dialog-type="activate"
                                data-whatever="@twbootstrap">
                                활성화
                            </button>
                        <?php elseif($site->status == 'ACTIVATED'): ?>
                            <?php echo $site->activate_date; ?>
                            <button 
                                class="btn btn-primary btn-xs" 
                                data-toggle="modal" 
                                data-target="#modal-change" 
                                data-dialog-type="activate-pending"
                                data-whatever="@twbootstrap">
                                연장
                            </button>
                        <?php elseif($site->status == 'ACTIVATED PENDING'): ?>
                            <?php echo $site->activate_date; ?>
                            <button 
                                class="btn btn-success btn-xs" 
                                data-toggle="modal" 
                                data-target="#modal-change" 
                                data-dialog-type="cancel-activate-pending"
                                data-whatever="@twbootstrap">
                                연장 요청 취소
                            </button>
                        <?php else: ?>
                            <button 
                                class="btn btn-success btn-xs" 
                                data-toggle="modal" 
                                data-target="#modal-change" 
                                data-dialog-type="cancel-activate"
                                data-whatever="@twbootstrap">
                                요청 취소
                            </button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="make-switch" data-on="success" data-off="default">
                            <input 
                                name="default" 
                                type="checkbox" 
                                <?php echo $site->is_default == 1 ? 'checked="checked"' : ''; ?>
                                <?php echo 
                                    $site->status == "ACTIVATED" 
                                    || $site->status == "ACTIVATED PENDING" 
                                    ? ''
                                    : 'disabled="disabled"'; 
                                ?>
                            >
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($this->data['sites']) < 1) : ?>
                <tr>
                    <td style="text-align:center;" colspan="5">연동 데이터가 없습니다. <a class="btn-google-connection" src="#">구글 계정 연동</a> 버튼을 눌러주세요.</td>
                </tr>
                <?php endif; ?>
			</tbody>
			<!-- // Table body END -->
			
		</table>
		<!-- // Table END -->
        
<!-- Modal -->
<div class="modal fade" id="modal-change">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal heading -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">사이트 활성화 요청</h3>
			</div>
			<!-- // Modal heading END -->
            
            <form role="form" action="ajax-site-status-change" class="for-activate">
                <input id="csrf_token" type="hidden" 
                    name="<?=$this->security->get_csrf_token_name()?>" 
                    value="<?=$this->security->get_csrf_hash()?>" />
                <input id="sid" type="hidden" name="sid" value="" />
                <input id="status" type="hidden" name="status" value ="" />
                <!-- Modal body -->
                <div class="modal-body">
                    <p id="msg">사이트 활성화를 위해서 결제를 진행해야 합니다. abc@abc.com 혹은 010-1234-5678로 문의바랍니다. 추후 PG로 교체</p>
                </div>
                <!-- // Modal body END -->
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">닫기</a> 
                    <button id="btn-submit" class="btn btn-primary">요청</button>
                </div>
                <!-- // Modal footer END -->
            </form>
		</div>
	</div>
</div>
<!-- // Modal END -->
        
        
            <!--div class="col-lg-4">
                <div class="dataTables_info" id="DataTables_Table_1_info">
                    Showing 1 to 10 of 57 entries
                </div>
            </div>
            <div class="col-lg-8">
                <div class="dataTables_paginate paging_bootstrap">
                    <ul class="pagination">
                        <li class="prev disabled">
                            <a href="#">← First</a>
                        </li>
                        <li class="prev disabled">
                            <a href="#">← Previous</a>
                        </li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li class="next disabled">
                            <a href="#">Next → </a>
                        </li>
                        <li class="next disabled">
                            <a href="#">Last → </a>
                        </li>
                    </ul>
                </div>
            </div-->
                    </div>
                </div>
                <input id="csrf_token" type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
            </div>
        </div>
    </div>
</div>
