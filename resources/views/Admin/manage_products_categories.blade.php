@extends('Admin/layout')
@section('page_title', 'Product Category Create|Update | MAKITA')
@section('productcategory_select', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Category Mangement Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/productcategory') }}">Product Category List</a>
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
                                <h3 class="card-title">Operate Product Category Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('productcategory.manage-productcategory-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputName">Category Name*</label>
                                            <input type="text" class="form-control" name="category_name"
                                                value="{{ $category_name }}" required id="exampleInputProCateName"
                                                placeholder="Enter category name">
                                            @error('category_name')
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
                                        <div class="form-group col-md-4">
                                            <label>Parent Category</label>
                                            <select class="custom-select" name="parent_category_id">
                                                <option value="0">Please Select</option>
                                                @foreach ($allcategories as $prodCateList)
                                                    <option @if ($prodCateList->id == $parent_category_id) selected @endif
                                                        value="<?= $prodCateList->id ?>"><?= $prodCateList->category_name ?>
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_category_id')
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
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Category Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="category_image" class="custom-file-input"
                                                        id="choose-file"
                                                        accept=".doc,.docx,.pdf,image/png, image/jpeg,image/png">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Category Status*</label>
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
                                        <div class="form-group col-md-4">

                                        </div>
                                        <div class="form-group col-md-4">

                                            <div id="img-preview" style="height: 100px">
                                                @if ($category_image != '')
                                                <img src="{{ asset($category_image) }}" height="100px">
                                               @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" value="{{ $category_slug }}" name="category_slug" required />
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
        <script>
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
                        imgPreview.innerHTML = '<img src="' + this.result + '" style="height:100px" />';
                    });
                }
            }
            $(function() {
                bsCustomFileInput.init();
            });
        </script>
    @endpush
@endsection
