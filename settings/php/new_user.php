<div class="card-body">
  <form class="forms-sample row">
    <div class="form-group col-sm-6">
      <label for="name">Name</label>
      <input type="text" class="form-control form-control-sm" id="name" placeholder="Name">
    </div>
    <div class="form-group col-sm-6">
      <label for="phone">Phone Number</label>
      <input type="text" class="form-control form-control-sm" id="phone" placeholder="Phone">
    </div>
    <div class="form-group col-sm-6">
      <label for="email">Email address</label>
      <input type="email" class="form-control form-control-sm" id="email" placeholder="Email">
    </div>
    <div class="form-group col-sm-6">
      <label for="role">Role</label>
      <select class="form-control form-control-sm" id="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <div class="form-group col-sm-6">
      <label for="password">Password</label>
      <input type="password" class="form-control form-control-sm" id="password" placeholder="Password">
    </div>
    <div class="col-sm-12">
      <button type="button" class="btn btn-sm btn-primary mr-2" onclick="saveUser()">Submit</button>
      <button type="reset" class="btn btn-sm btn-light">Reset</button>
    </div>
  </form>
</div>