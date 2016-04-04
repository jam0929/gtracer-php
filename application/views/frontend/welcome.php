<!-- main items -->
<div class="row start">
    <div id="start" class="col-xs-12 col-sm-6 col-md-offset-1 col-md-5 text-center main-items">
        <div class="row">
            <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                <img src="<?php echo base_url(); ?>assets/img/main-01.png">
                <h3 class="tile-title">ABOUT G-Tracer</h3>
                <p>웹 데이터 분석 솔루션 G-Tracer를 소개 해 드립니다.</p>
                <a class="btn btn-primary btn-large btn-block" href="/#about">
                    상세 내용 보러가기
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-5 text-center main-items">
        <div class="row">
            <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                <img src="<?php echo base_url(); ?>assets/img/main-02.png">
                <h3 class="tile-title">G-Tracer Pricing</h3>
                <p>G-Tracer 서비스 별 가격 정책을 알려드립니다.</p>
                <a class="btn btn-primary btn-large btn-block" href="/#pricing">
                    상세 내용 보러가기
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-5 text-center main-items">
        <div class="row">
            <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                <img src="<?php echo base_url(); ?>assets/img/main-03.png">
                <h3 class="tile-title">G-Tracer Login</h3>
                <p>G-Tracer 서비스 가입 회원 로그인</p>
                <a class="btn btn-primary btn-large btn-block" href="<?php echo base_url(); ?>auth/login">
                    LOGIN
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-5 text-center main-items">
        <div class="row">
            <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                <img src="<?php echo base_url(); ?>assets/img/main-04.png">
                <h3 class="tile-title">LAB543 홈페이지</h3>
                <p>&nbsp;</p>
                <a class="btn btn-primary btn-large btn-block" href="http://lab543.com" target="_new">
                    LAB543 보러가기
                </a>
            </div>
        </div>
    </div>
</div>
<!-- /main-items -->

<hr class="line-separator" />

<!-- contact -->
<div id="contact" class="contact">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-5">
            <h3>G-Tracer Made By LAB543</h3>
            <p>
                LAB543의 문은 언제나 열려 있습니다.
            </p>
            <p>
                주소: 서울특별시 강남구 학동로33길 17(논현동) 수산빌딩 2층<br />
                전화번호: 02-543-3779<br />
                Fax: 02-543-3795
            </p>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-5 text-center">
            <h3>문의하기</h3>
            <p>
                G-Tracer에 궁금하신 점을 남겨주시면 <br />바로 안내 해 드리겠습니다.
            </p>
            <form id="form_mail" class="row margin-bottom-9em" onsubmit="return false;" method="post"> 
                <div class="col-xs-6 col-sm-4"> 
                    <input type="text" name="name" class="form-control input-sm" placeholder="이름" required="true"> 
                </div> 
                <div class="col-xs-6 col-sm-4"> 
                    <input type="text" name="phone" class="form-control input-sm" placeholder="연락처" required="true"> 
                </div> 
                <div class="col-xs-12 col-sm-4"> 
                    <input type="text" name="email" class="form-control input-sm" placeholder="이메일주소" required="true"> 
                </div> 
                <div class="col-xs-12"> 
                    <input type="text" name="title" class="form-control input-sm" placeholder="제목" required="true"> 
                </div> 
                <div class="col-xs-12"> 
                    <textarea name="content" class="form-control input-sm" rows="4" placeholder="내용" required="true"></textarea> 
                </div> 
                <div class="col-xs-12"> 
                    <input id="send-mail" type="submit" class="form-control btn-sm" value="Submit"> 
                </div> 
            </form>
        </div>
    </div>
</div>
<!-- /contact -->

<hr class="line-separator" />

<!-- about -->
<div id="about" class="about">
    <h2 class="text-center">ABOUT G-Tracer</h2>
    <p class="text-center">
        G-Tracer는 온라인 몰 운영 파악에 필요한 요소를 핵심적으로 분석하는 시스템입니다.
    </p>
    
    <div class="row">
        <div class="col-xs-12 col-sm-4 text-center about-items">
            <div class="row">
                <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                    <img src="assets/img/about-01.png" />
                    <h3>고객 유입 분석</h3>
                    <p>
                        유저 유형 분석
                    </p>
                    <p>
                        유입 채널 별 접속 / 이탈 분석
                    </p>
                    <p>
                        유입 채널 별 PV 분석
                    </p>
                    <p>
                        유입 채널 별 매출 분석
                    </p>
                    <p>
                        회원가입 유입 채널 분석
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 text-center about-items">
            <div class="row">
                <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                    <img src="assets/img/about-02.png" />
                    <h3>상품 및 카테고리 분석</h3>
                    <p>
                        상품 수익 분석
                    </p>
                    <p>
                        개별 상품 별 유입 채널 분석
                    </p>
                    <p>
                        주요 상품 매출 순위 분석
                    </p>
                    <p>
                        상품 판매량 단계 별 측정
                    </p>
                    <p>
                        상품 카테고리 별 분석
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 text-center about-items">
            <div class="row">
                <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                    <img src="assets/img/about-03.png" />
                    <h3>사용자 성향 분석</h3>
                    <p>
                        방문고객 소스코드를 통한 데이터 수집
                    </p>
                    <p>
                        방문 이전 경로 수집을 통한<br />
                        관심사 및 인마켓 세그먼트 구분
                    </p>
                    <p>
                        고객 관심사 별 실제 판매  상품 분석
                    </p>
                    <p>
                        관심사 별 개별 판매 순위 파악
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-5 text-center about-items">
            <div class="row">
                <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                    <img src="assets/img/about-04.png" />
                    <h3>인사이트 행동 분석</h3>
                    <p>
                        사이트 방문 고객의 쇼핑몰 내부 행동 분석
                    </p>
                    <p>
                        메인 페이지 / 개별 상세페이지의 가치,<br />
                        이탈율 등의 효율성 측정
                    </p>
                    <p>
                        고객에게 인기 높은 페이지 분석
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-5 text-center about-items">
            <div class="row">
                <div class="col-xs-12 col-lg-offset-1 col-lg-10">
                    <img src="assets/img/about-05.png" />
                    <h3>이익 기여도 분석</h3>
                    <p>
                        상품 원가 대비 수익율 분석
                    </p>
                    <p>
                        카테고리 원가 대비 수익율 분석
                    </p>
                    <p>
                        개별 상품 ROAS 분석
                    </p>
                    <p>
                        상품 가격대 분석
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center">
        <a class="btn btn-primary btn-large" href="http://lab543.com/new/150317_g-tracer.pdf">
            <b>G-Tracer 제품 소개서 다운로드</b>
        </a>
    </div>
</div>
<!-- about -->

<!--
<h1 class="page-header">Welcome - hwangoon</h1>

<div class="row demo-tiles">
    <div class="col-xs-6">
      <div class="tile">
        <img src="<?php echo base_url(); ?>assets/img/icons/svg/compas.svg" alt="Compas" class="tile-image big-illustration">
        <h3 class="tile-title">Web Oriented</h3>
        <p>100% convertable to HTML/CSS layout.</p>
        <a class="btn btn-primary btn-large btn-block" href="http://designmodo.com/flat">Get Pro</a>
      </div>
    </div>

    <div class="col-xs-6">
      <div class="tile">
        <img src="<?php echo base_url(); ?>assets/img/icons/svg/loop.svg" alt="Infinity-Loop" class="tile-image">
        <h3 class="tile-title">Easy to Customize</h3>
        <p>Vector-based shapes and minimum of layer styles.</p>
        <a class="btn btn-primary btn-large btn-block" href="http://designmodo.com/flat">Get Pro</a>
      </div>
    </div>

    <div class="col-xs-6">
      <div class="tile">
        <img src="<?php echo base_url(); ?>assets/img/icons/svg/pencils.svg" alt="Pensils" class="tile-image">
        <h3 class="tile-title">Color Swatches</h3>
        <p>Easy to add or change elements. </p>
        <a class="btn btn-primary btn-large btn-block" href="http://designmodo.com/flat">Get Pro</a>
      </div>
    </div>

    <div class="col-xs-6">
      <div class="tile tile-hot">
        <img src="<?php echo base_url(); ?>assets/img/icons/svg/ribbon.svg" alt="ribbon" class="tile-hot-ribbon">
        <img src="<?php echo base_url(); ?>assets/img/icons/svg/chat.svg" alt="Chat" class="tile-image">
        <h3 class="tile-title">Free for Share</h3>
        <p>Your likes, shares and comments helps us.</p>
        <a class="btn btn-primary btn-large btn-block" href="http://designmodo.com/flat">Get Pro</a>
      </div>

    </div>
</div>
-->
