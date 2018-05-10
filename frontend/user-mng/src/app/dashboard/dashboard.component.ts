import { Component, OnInit, ViewContainerRef } from '@angular/core';
import { UserService } from '../services/userService/user.service';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { NgbModal, ModalDismissReasons } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
  allUsers: any = [];

  constructor(public users: UserService, private toastr: ToastrService,
    private modalService: NgbModal) {
  }
  isEdit: boolean;
  user = {
    firstname: '',
    lastname: '',
    email: '',
    password: ''
  };
  userInfo: Object;
  userGroups: any;

  ngOnInit() {
    this.getUsers();
  }

  open(content, user, isDelete) {
    if (isDelete === 'delete') {
      this.deleteUser(content, user);
    } else {
      user !== undefined ? this.editUser(content, user) : this.createUser(content);
    }
  }


  editUser(content, user) {
    this.isEdit = true;
    this.user = user;
    this.modalService.open(content).result.then((result) => {
      if (result !== 'close') {
        this.user = result;
        this.update(this.user);
      }
    });
  }

  update(user) {
    this.users.update(user).subscribe(data => {
      this.getUsers();
      this.toastr.success('User Updated!', 'Success!');
    });
  }


  createUser(content) {
    this.isEdit = false;
    this.modalService.open(content).result.then((result) => {
      if (result !== 'close') {
        this.save(result);
      }
    });
  }

  save(user) {
    const userData = {
      'firstname': user.firstname,
      'lastname': user.lastname,
      'email': user.email,
      'password': user.password,
    };

    this.users.create(userData).subscribe(data => {
      this.getUsers();
      this.toastr.success('User Created!', 'Success!');
    });
  }

  addUserToGroup(user) {
    this.users.addUserToGroup(user).subscribe(data => {
      this.getUsers();
      this.toastr.success('User Deleted!', 'Success!');
    }, error => this.toastr.error('User is in group!', 'Error!'));
  }

  deleteUser(content, user) {
    this.isEdit = false;
    this.userInfo = user;
    this.modalService.open(content).result.then((result) => {
      if (result !== 'close') {
        this.delete(user);
      }
    });
  }

  delete(user) {
    this.users.delete(user).subscribe(data => {
      this.getUsers();
      this.toastr.success('User Deleted!', 'Success!');
    }, error => this.toastr.error('User is in group!', 'Error!'));
  }


  getUsers() {
    this.users.getUsers().subscribe(data => {
      this.allUsers = data;
    });
  }
}

