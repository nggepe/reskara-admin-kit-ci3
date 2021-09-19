<link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/select2-4.1.0/select2.min.css">

<div class="container-xxl">
  <nav class="breadcrumb bg-transparent px-3 align-items-center" aria-label="breadcrumb">
    <div>
      <div class="fs-5 fw-bold text-solid">Privilege</div>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><small>Master</small></a></li>
        <li class="breadcrumb-item active" aria-current="page"><small>Privilege</small></li>
      </ol>
    </div>
    <div>
      <button class="btn btn-primary btn-sm primary-y-shadow add-new-privilege"><i class="fa fa-plus me-2"></i>Add New Privilege</button>
    </div>
  </nav>
  <div class="row px-3">
    <div class="col-12">
      <div class="card card-success mb-5" id="card-form">
        <div class="card-header">
          <div class="card-title">Add New Privilege</div>
          <div class="card-title-actions">
            <button class="hover-shadow collapse-card" data-hide='<i class="fa fa-plus"></i>' data-show='<i class="fa fa-minus"></i>'>
            </button>
            <button class="hover-shadow full-screen-card"><i class="fa fa-expand"></i></button>
            <button class="hover-shadow close-card"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="collapse-card-item">
          <form id="privilege-form" action="#" method="POST">
            <div class="card-body text-secondary">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" required name="name">
                </div>
              </div>
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-save me-2"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title text-secondary"><b>Privilege Data</b></div>
          <div class="card-title-actions">
            <button class="hover-shadow collapse-card" data-hide='<i class="fa fa-plus"></i>' data-show='<i class="fa fa-minus"></i>'>
            </button>
            <button class="hover-shadow full-screen-card"><i class="fa fa-expand"></i></button>
          </div>
        </div>
        <div class="collapse-card-item">
          <div class="card-body text-secondary">
            <table class='table table-stripped table-bordered table-hovered w-100' id="privilege-table">
              <thead class="text-center">
                <th style="width: 80px;">No.</th>
                <th>Name</th>
                <th style="width: 143px;">#</th>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="privilege-modal" tabindex="-1" aria-labelledby="privilege-modal-Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="privilege-modal-Label">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>public/assets/js/components.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-1.11.1/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/select2-4.1.0/select2.min.js"></script>
<script src="<?= base_url() ?>public/assets/js/admin/setting/jquery.privilege.js"></script>