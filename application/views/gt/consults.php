<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">컨설팅 보고서 &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h3>
                     
                    <!--
                    <div class="btn-group pull-right">
						<a href="dashboard_analytics.html" class="btn btn-primary disabled">
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
                    -->
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
					<th data-class="expand">업로드 날짜</th>
					<th data-class="expand">제목</th>
					<th data-class="expand">다운로드</th>
				</tr>
			</thead>
			<!-- // Table heading END -->
			
			<!-- Table body -->
			<tbody id="consult-list">
                <tr data-sid=""
                    data-status="">
                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                    <td>2015년 1월 셋째주 컨설팅 보고서</td>
                    <td>
                        <button class="btn btn-primary btn-xs">다운로드</button>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;" colspan="5">
                        업로드 된 보고서가 없습니다.
                    </td>
                </tr>
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
