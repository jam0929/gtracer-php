<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">

				<div class="innerTB">
					<h3 class="margin-none pull-left">사용자 관리 &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h3>

                    <div class="btn-group pull-right">
						<a href="<?php echo base_url('auth/register?redirect_to='.urlencode(uri_string())) ?>" class="btn btn-primary">
                            <i class="fa fa-fw fa-bar-chart-o"></i> 신규 사용자 생성
                        </a>
                        <!--
						<a href="dashboard_users.html" class="btn btn-default">
                            <i class="fa fa-fw fa-user"></i> Users
                        </a>
						<a href="dashboard_overview.html" class="btn btn-default">
                            <i class="fa fa-fw fa-dashboard"></i> Overview
                        </a>

                        -->
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="col-separator-h"></div>

                <div class="row">
                    <div class="col-xs-12">

<!-- Table -->
		<table class="footable table table-striped table-primary user-table">

			<!-- Table heading -->
			<thead>
				<tr>
					<th data-class="expand">아이디</th>
					<th data-class="expand">이메일</th>
                    <th data-hide="phone,tablet">사이트 관리</th>
                    <th data-hide="phone,tablet">연결된 구글 계정 초기화</th>
					<th data-hide="phone,tablet">패드워드</th>
					<th data-hide="phone,tablet">권한</th>
					<th data-hide="phone,tablet">계정 비활성화</th>
                    <th data-hide="phone,tablet">계정 삭제</th>
					<th>가입일</th>
				</tr>
			</thead>
			<!-- // Table heading END -->

			<!-- Table body -->
			<tbody>
                <?php foreach($this->data['users'] as $user) : ?>
				<tr data-uid="<?php echo $user->id; ?>">
					<td><?php echo $user->username; ?></td>
					<td><?php echo $user->email; ?></td>
                    <td>
                        <a href="<?php echo base_url('admin/sites/'.$user->id) ?>"
                            class="btn btn-primary btn-xs">
                            <i class="fa fa-fw fa-bar-chart-o"></i> 사이트 관리
                        </a>
                    </td>
                    <td>
                        <button
                            class="btn btn-warning btn-xs"
                            data-toggle="modal"
                            data-target="#modal-change"
                            data-dialog-type="google-init"
                            data-uid="<?php echo $user->id; ?>"
                            data-username="<?php echo $user->username; ?>"
                            data-whatever="@twbootstrap">
                            초기화
                        </button>
                    </td>
					<td>
                        <button
                            class="btn btn-warning btn-xs"
                            data-toggle="modal"
                            data-target="#modal-change"
                            data-dialog-type="password"
                            data-uid="<?php echo $user->id; ?>"
                            data-username="<?php echo $user->username; ?>"
                            data-whatever="@twbootstrap">
                            변경
                        </button>
                    </td>
					<td>
                        <span class='user-permission'><?php echo $user->is_admin == 1 ? '어드민' : '기본유저' ?></span>
                        <button
                            class="btn btn-warning btn-xs"
                            data-toggle="modal"
                            data-target="#modal-change"
                            data-dialog-type="permission"
                            data-uid="<?php echo $user->id; ?>"
                            data-username="<?php echo $user->username; ?>"
                            data-whatever="@twbootstrap">
                            변경
                        </button>
                    </td>
					<td>
                        <button
                            class="btn btn-<?php echo $user->banned == 0 ? 'warning' : 'success'; ?> btn-xs"
                            data-toggle="modal"
                            data-target="#modal-change"
                            data-dialog-type="disable"
                            data-uid="<?php echo $user->id; ?>"
                            data-username="<?php echo $user->username; ?>"
                            data-is_banned="<?php echo $user->banned; ?>"
                            data-whatever="@twbootstrap">
                            <?php echo $user->banned == 0 ? '비활성화' : '활성화'; ?>
                        </button>
                    </td>
                    <td>
                        <button
                            class="btn btn-warning btn-xs"
                            data-toggle="modal"
                            data-target="#modal-change"
                            data-dialog-type="user-delete"
                            data-uid="<?php echo $user->id; ?>"
                            data-username="<?php echo $user->username; ?>"
                            data-whatever="@twbootstrap">
                            삭제
                        </button>
                    </td>
					<td><?php echo $user->created; ?></td>
				</tr>
                <?php endforeach; ?>
				<!-- // Table row END -->

			</tbody>
			<!-- // Table body END -->

		</table>
		<!-- // Table END -->

        <?php echo $this->pagination->create_links(); ?>


            <!--div class="col-lg-4">
                <div class="dataTables_info" id="DataTables_Table_1_info">
                    Showing <?php echo $this->data['offset']+1; ?> to <?php echo $this->data['offset']+count($this->data['users']) < $this->data['user_count'] ? $this->data['offset']+count($this->data['users']) : $this->data['user_count']; ?> of <?php echo $this->data['user_count']; ?> entries
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
                        <li>
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#">4</a>
                        </li>
                        <li>
                            <a href="#">5</a>
                        </li>
                        <li class="next">
                            <a href="#">Next → </a>
                        </li>
                        <li class="next">
                            <a href="#">Last → </a>
                        </li>
                    </ul>
                </div>
            </div-->

                    </div>
                </div>
        <div class="modal fade" id="modal-change" tabindex="-1" role="dialog">

            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal heading -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Modal header</h3>
                    </div>
                    <!-- // Modal heading END -->

                    <form role="form" action="ajax-google-init" class="for-google-init">
                        <input id="csrf_token" type="hidden"
                            name="<?=$this->security->get_csrf_token_name()?>"
                            value="<?=$this->security->get_csrf_hash()?>" />
                        <input id="uid" type="hidden" name="uid" value="" />
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                현재 연결되어 있는 구글 계정을 초기화 하시겠습니까?
                            </div>
                        </div>
                        <!-- // Modal body END -->

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                            <button class="btn btn-primary">Yes</button>
                        </div>
                        <!-- // Modal footer END -->

                    </form>

                    <form role="form" action="ajax-change-password" class="for-password">
                        <input id="csrf_token" type="hidden"
                            name="<?=$this->security->get_csrf_token_name()?>"
                            value="<?=$this->security->get_csrf_hash()?>" />
                        <input id="uid" type="hidden" name="uid" value="" />
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="password" class="control-label">New password:</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                        </div>
                        <!-- // Modal body END -->

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                            <button class="btn btn-primary">Save changes</button>
                        </div>
                        <!-- // Modal footer END -->

                    </form>

                    <form role="form" class="for-permission" action="ajax-change-permission">
                        <input type="hidden"
                            name="<?=$this->security->get_csrf_token_name()?>"
                            value="<?=$this->security->get_csrf_hash()?>" />
                        <input type="hidden" id="uid" name="uid" value="" />
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="permission" class="control-label">Permission:</label>
                                <select name="isAdmin">
                                    <option value="0">기본유저</option>
                                    <option value="1">어드민</option>
                                </select>
                            </div>
                        </div>
                        <!-- // Modal body END -->

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                            <button class="btn btn-primary">Save changes</button>
                        </div>
                        <!-- // Modal footer END -->

                    </form>

                    <form role="form" action="ajax-change-banned" class="for-disable">
                        <input id="csrf_token" type="hidden"
                            name="<?=$this->security->get_csrf_token_name()?>"
                            value="<?=$this->security->get_csrf_hash()?>" />
                        <input id="uid" type="hidden"
                            name="uid" value="" />
                        <input id="is_banned" type="hidden"
                            name="is_banned" value="0" />
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="reason" class="control-label">Reason:</label>
                                <input type="text" name="reason" class="form-control" id="reason">
                            </div>
                        </div>
                        <!-- // Modal body END -->

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                            <button class="btn btn-primary">Save changes</button>
                        </div>
                        <!-- // Modal footer END -->

                    </form>
                    
                    <form role="form" action="ajax-user-delete" class="for-user-delete">
                        <input id="csrf_token" type="hidden"
                            name="<?=$this->security->get_csrf_token_name()?>"
                            value="<?=$this->security->get_csrf_hash()?>" />
                        <input id="uid" type="hidden" name="uid" value="" />
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                계정을 삭제하시겠습니까?
                            </div>
                        </div>
                        <!-- // Modal body END -->

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                            <button class="btn btn-primary">Yes</button>
                        </div>
                        <!-- // Modal footer END -->

                    </form>
                </div>
            </div>

        </div>
            </div>
        </div>
    </div>
</div>