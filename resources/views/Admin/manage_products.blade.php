@extends('Admin/layout')
@section('page_title', 'Product Create|Update | MAKITA')
@section('product_select', 'active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
            <!-- Select2 -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
            <!-- summernote -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.css') }}">
            <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
        @endpush
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products Mangement Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/productcategory') }}">Products List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Product Category</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Operate Product Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('product.manage-product-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Category</label>
                                            <select class="form-control select2" name="category_id"
                                                style="width: 100%;">
                                                <option value="">Please Select</option>
                                                @foreach ($categories as $categoryList)
                                                    <option @if ($categoryList->id == $category_id) selected @endif
                                                        value="<?= $categoryList->id ?>"><?= $categoryList->category_name ?>
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputName">Product Name*</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $name }}" required id="exampleInputProductName"
                                                placeholder="Enter Product Name">
                                            @error('name')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputName">Model*</label>
                                            <input type="text" class="form-control" name="model"
                                                value="{{ $model }}" required id="exampleInputProductModel"
                                                placeholder="Enter Product Model">
                                            @error('model')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputProductCode">Product Price*</label>
                                            <input type="text" class="form-control" name="product_price"
                                                value="{{ $product_price }}" required id="exampleInputProductPrice"
                                                placeholder="Enter Product Price">
                                            @error('product_price')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputShortDescription">Short Description*</label>
                                            <textarea class="form-control" name="short_description" rows="1" placeholder="Enter Product Short Description">{{$short_description}}</textarea>
                                            @error('short_description')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputLongDescription">Long Description*</label>
                                            <textarea id="summernote" name="long_description">{{$long_description}}</textarea>
                                            @error('long_description')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputTechnicalInformation">Technical Information*</label>
                                            <textarea id="summernote2" name="technical_info">{{$technical_info}}</textarea>
                                            @error('technical_info')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputGeneralInformation">General Information*</label>
                                            <textarea id="summernote3" name="general_info">{{$general_info}}</textarea>
                                            @error('general_info')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputSupport">Support*</label>
                                            <textarea id="summernote4" name="support">{{$support}}</textarea>
                                            @error('support')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleVideoLink">Video Link*</label>
                                            <textarea id="summernote5" name="video_link">{{$video_link}}</textarea>
                                            @error('video_link')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputKeywords">Keywords*</label>
                                            <textarea class="form-control" name="keywords" rows="6" placeholder="Enter Product KeyWords">{{$keywords}}</textarea>
                                            @error('keywords')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputPrimaryImage">Primary Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="primary_image" class="custom-file-input"
                                                        id="choose-file"
                                                        accept="image/png, image/jpeg,image/png">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputName">Warranty*</label>
                                            <input type="text" class="form-control" name="warranty"
                                                value="{{ $warranty }}" required id="exampleInputWarranty"
                                                placeholder="Enter Warranty(in Months)">
                                            @error('warranty')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Status*</label>
                                            <select class="custom-select" name="status" required>
                                                <option value="">Please Select</option>
                                                <option @if ($status == 1) selected @endif value="1">
                                                    Active
                                                </option>
                                                <option @if ($status == 0) selected @endif value="0">
                                                    De-Active
                                                </option>
                                            </select>
                                            @error('status')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Tax*</label>
                                            <select class="custom-select" name="tax_id" required>
                                                <option value="">Please Select</option>
                                                <option value="1">GST 18%</option>
                                            </select>
                                            @error('tax_id')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-3 pid" {{(Crypt::decrypt($product_slug))=== 0 ? "style=display:none":""}} >
                                            <div id="img-preview" style="height: 100px">
                                                @if ($primary_image != '')
                                                <img src="{{ asset($primary_image) }}" height="100px">
                                               @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" value="{{ $product_slug }}" name="product_slug" required />
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <script src="{{ asset('admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
        <!-- Summernote -->
        <script src="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

        <script>
            $(function() {
                bsCustomFileInput.init();
                //Initialize Select2 Elements
                $('.select2').select2()
                // Summernote
                $('#summernote').summernote()
                $('#summernote2').summernote()
                $('#summernote3').summernote()
                $('#summernote4').summernote()
                $('#summernote5').summernote()
            });

            const chooseFile = document.getElementById("choose-file");
            const imgPreview = document.getElementById("img-preview");
            chooseFile.addEventListener("change", function() {
                getImgData();
            });

            function getImgData() {
                const files = chooseFile.files[0];
                if (files) {
                    const fileReader = new FileReader();
                    fileReader.readAsDataURL(files);
                    fileReader.addEventListener("load", function() {
                        imgPreview.style.display = "block";
                        imgPreview.innerHTML = '<img src="' + this.result + '" style="height:100px;" />';
                        $(".pid").show();
                    });
                }
            }
        </script>
    @endpush
@endsection
