@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@php
    if ($action == 'create') {
        $action = route('material.create_material');

        $button_text = 'Thêm';
    } else {
        $action = route('material.edit_material');

        $button_text = 'Cập Nhật';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('material.index') }}" class="btn btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="row mb-8">

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Tên Vật Tư</label>

                            <input type="text" class="form-control form-control-sm form-control-solid" name=""
                                placeholder="Tên Vật Tư..">

                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Nhóm Vật Tư</label>

                            <select name="" class="form-select form-select-sm form-select-solid">
                                <option value="0">Chọn Nhóm Vật Tư...</option>
                                <option value="A">A</option>
                            </select>
                        </div>

                    </div>

                    <div class="row mb-8">

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Đơn Vị Tính</label>

                            <select name="" class="form-select form-select-sm form-select-solid">
                                <option value="0">Chọn Đơn Vị Tính...</option>
                                <option value="box">Hộp</option>
                                <option value="bottle">Chai</option>
                                <option value="tube">Ống</option>
                                <option value="pack">Gói</option>
                                <option value="tablet">Viên</option>
                                <option value="vial">Lọ</option>
                                <option value="ampoule">Ống tiêm</option>
                                <option value="bag">Túi</option>
                                <option value="set">Bộ</option>
                                <option value="piece">Cái</option>
                                <option value="kit">Bộ dụng cụ</option>
                                <option value="roll">Cuộn</option>
                                <option value="pair">Đôi</option>
                                <option value="strip">Vỉ</option>
                                <option value="sachet">Gói nhỏ</option>
                                <option value="canister">Bình</option>
                                <option value="carton">Thùng</option>
                                <option value="liter">Lít</option>
                                <option value="milliliter">Millilit</option>
                                <option value="gram">Gram</option>
                                <option value="kilogram">Kilogram</option>
                            </select>

                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Số Lượng</label>

                            <input type="number" class="form-control form-control-sm form-control-solid" name=""
                                value="0">

                        </div>

                    </div>

                    <div class="row mb-8">

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Giá</label>

                            <input type="number" class="form-control form-control-sm form-control-solid" name=""
                                value="0">
                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-3">Hạn Sử Dụng (Nếu Có)</label>

                            <input type="date" class="form-control form-control-sm form-control-solid" name="">

                        </div>

                    </div>

                    <div class="row mb-8">

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Nhà Cung Cấp</label>

                            <select name="" class="form-select form-select-sm form-select-solid">
                                <option value="0">Chọn Nhà Cung Cấp...</option>
                                <option value="A">A</option>
                            </select>
                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Nước Cung Cấp</label>

                            <select name="" data-control="select2" data-dropdown-parent="#kt_modal_new_address"
                                class="form-select form-select-sm form-select-solid">
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Aland Islands">Quần đảo Aland</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">Samoa thuộc Mỹ</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antigua and Barbuda">Antigua và Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Úc</option>
                                <option value="Austria">Áo</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Bỉ</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius và Saba</option>
                                <option value="Bosnia and Herzegovina">Bosnia và Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Territory">Lãnh thổ Ấn Độ Dương thuộc Anh</option>
                                <option value="Brunei Darussalam">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Campuchia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Cape Verde">Cabo Verde</option>
                                <option value="Cayman Islands">Quần đảo Cayman</option>
                                <option value="Central African Republic">Cộng hòa Trung Phi</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">Trung Quốc</option>
                                <option value="Christmas Island">Đảo Christmas</option>
                                <option value="Cocos (Keeling) Islands">Quần đảo Cocos (Keeling)</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Cook Islands">Quần đảo Cook</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Côte d'Ivoire">Bờ Biển Ngà</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curaçao">Curaçao</option>
                                <option value="Czech Republic">Cộng hòa Séc</option>
                                <option value="Denmark">Đan Mạch</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Cộng hòa Dominica</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Ai Cập</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Guinea Xích Đạo</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands (Malvinas)">Quần đảo Falkland (Malvinas)</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Phần Lan</option>
                                <option value="France">Pháp</option>
                                <option value="French Polynesia">Polynesia thuộc Pháp</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Đức</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Greece">Hy Lạp</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guernsey">Guernsey</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Vatican City">Thành Vatican</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hồng Kông</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">Ấn Độ</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran, Islamic Republic of">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Đảo Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Ý</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Nhật Bản</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="North Korea">Triều Tiên</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Laos">Lào</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Liban</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macau">Macau</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Quần đảo Marshall</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Micronesia, Federated States of">Liên bang Micronesia</option>
                                <option value="Moldova">Moldova</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mông Cổ</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Hà Lan</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Đảo Norfolk</option>
                                <option value="Northern Mariana Islands">Quần đảo Bắc Mariana</option>
                                <option value="Norway">Na Uy</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau">Palau</option>
                                <option value="Palestinian Territory, Occupied">Lãnh thổ Palestine</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Poland">Ba Lan</option>
                                <option value="Portugal">Bồ Đào Nha</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Romania">Romania</option>
                                <option value="Russia">Nga</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Réunion">Réunion</option>
                                <option value="Saint Helena">Saint Helena</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts và Nevis</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Saint Martin">Saint Martin</option>
                                <option value="Saint Pierre and Miquelon">Saint Pierre và Miquelon</option>
                                <option value="Saint Vincent and the Grenadines">Saint Vincent và Grenadines</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome and Principe">Sao Tome và Principe</option>
                                <option value="Saudi Arabia">Ả Rập Saudi</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Sint Maarten">Sint Maarten</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Quần đảo Solomon</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">Nam Phi</option>
                                <option value="South Korea">Hàn Quốc</option>
                                <option value="South Sudan">Nam Sudan</option>
                                <option value="Spain">Tây Ban Nha</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Svalbard and Jan Mayen">Svalbard và Jan Mayen</option>
                                <option value="Eswatini">Eswatini</option>
                                <option value="Sweden">Thụy Điển</option>
                                <option value="Switzerland">Thụy Sĩ</option>
                                <option value="Syrian Arab Republic">Syria</option>
                                <option value="Taiwan">Đài Loan</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Thailand">Thái Lan</option>
                                <option value="Timor-Leste">Timor-Leste</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad và Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Thổ Nhĩ Kỳ</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks and Caicos Islands">Quần đảo Turks và Caicos</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">Các Tiểu Vương Quốc Ả Rập Thống Nhất</option>
                                <option value="United Kingdom">Vương quốc Anh</option>
                                <option value="United States">Hoa Kỳ</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Viet Nam" selected>Việt Nam</option>
                                <option value="Western Sahara">Tây Sahara</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                                <option value="Åland Islands">Quần đảo Åland</option>
                            </select>

                        </div>

                    </div>

                    <div class="row mb-8">

                        <div class="col-md-6 fv-row">

                            <div class="mb-5">
                                <label class="fs-5 fw-bold mb-3">Hình Ảnh</label>

                                <input type="file" class="form-control form-control-sm form-control-solid"
                                    name="" accept="image/*">
                            </div>

                            <div>
                                <label class="fs-5 fw-bold mb-3">Ảnh Đã Thêm</label>

                                <img src="https://dm0qx8t0i9gc9.cloudfront.net/thumbnails/video/rN0W64K4ipau8gxv/videoblocks-ha-ha-ha-word-in-speech-balloon-in-comic-style-animation-4k-retro-cartoon-comics-animation-on-green-screen_bblbcmyoz_thumbnail-1080_01.png"
                                    width="200" alt="imgae">
                            </div>

                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Mô Tả</label>

                            <textarea name="" id="" cols="30" rows="10"
                                class="form-control form-control-sm form-control-solid"></textarea>
                        </div>

                    </div>

                </div>
            </div>


            <div class="modal-footer flex-right">
                <button type="submit" id="kt_modal_new_address_submit" class="btn btn-twitter btn-sm">
                    {{ $button_text }}
                </button>
            </div>
        </form>
    </div>
@endsection
