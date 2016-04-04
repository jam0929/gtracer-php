<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">상품 원가 입력 &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h3>
                    <div class="row">
                        <ul class=" list-inline pull-right">
                            <li>
                                <button 
                                    id="get_product"
                                    class="btn btn-info">
                                    상품 목록 불러오기
                                </button>
                            </li>
                            
                            <li>
                                <button 
                                    id="get_excel_form"
                                    class="btn btn-info btn-excel-export"
                                    data-table="product-table"
                                    data-filename="product">
                                    엑셀 폼 다운로드
                                </button>
                            </li>
                            
                            <li>
                                <button 
                                    class="btn btn-info"
                                    data-toggle="modal" 
                                    data-target="#modal-product">
                                    엑셀 업로드
                                </button>
                            </li>
                            
                            <li>
                                <button 
                                    id="save_product"
                                    class="btn btn-info"
                                >
                                    변경사항 적용
                                </button>
                            </li>
                        </ul>
                    </div>
					<div class="clearfix"></div>
				</div>
				
				<div class="col-separator-h"></div>
                
                <div class="row">
                    <div class="col-xs-12">
                    
<!-- Table -->
<table id="product-table" class="footable table table-striped table-primary">

    <!-- Table heading -->
    <thead>
        <tr>
            <th data-class="expand">상품명</th>
            <th data-class="expand">원가</th>
        </tr>
    </thead>
    <!-- // Table heading END -->
    
    <!-- Table body -->
    <tbody id="product-list">
        <?php foreach($this->data['products'] as $product) : ?>
        <tr name="product">
            <td name="product_name"><?php echo $product->name; ?></td>
            <td>
                <input 
                    name="product_roi" 
                    type="text" 
                    value="<?php echo $product->roi; ?>" ></input>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <!-- // Table body END -->
    
</table>
<!-- // Table END -->
<!-- Modal -->
<div class="modal fade" id="modal-product">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal heading -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">엑셀 업로드</h3>
			</div>
			<!-- // Modal heading END -->
            
            <form 
                role="form" 
                action="<?php echo base_url('gt/ajaxProductUploadByExcel') ?>" 
                enctype="multipart/form-data"
                method="post"
                class="for-excel"
            >
                <input id="csrf_token" type="hidden" 
                    name="<?=$this->security->get_csrf_token_name()?>" 
                    value="<?=$this->security->get_csrf_hash()?>" />
                <input type="hidden" name="sid" value="<?php echo $this->data['sid']; ?>" />
                <input type="hidden" name="redirect" value="<?php echo $this->uri->uri_string(); ?>" />
                <!-- Modal body -->
                <div class="modal-body">
                    <p id="msg">엑셀파일을 업로드해주세요</p>
                    
                    <input 
                        type="file" 
                        name="product" 
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                </div>
                <!-- // Modal body END -->
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">닫기</a> 
                    <input type="submit" class="btn btn-primary" value="업로드" />
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
