import { Component, OnInit } from '@angular/core';
import { UserService } from '../services/userService/user.service';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { NgbModal, ModalDismissReasons } from '@ng-bootstrap/ng-bootstrap';
import { Router, ActivatedRoute, Params } from '@angular/router';

@Component({
  selector: 'app-details',
  templateUrl: './details.component.html',
  styleUrls: ['./details.component.css']
})
export class DetailsComponent implements OnInit {
  userId: Number;
  userGroupsInfo: any;
  constructor(public users: UserService,
    private activatedRoute: ActivatedRoute,
    private toastr: ToastrService) { }

  ngOnInit() {
    this.userGroupsInfo = {};
    // subscribe to router event
    this.activatedRoute.params.subscribe((params: Params) => {
      this.userId = params['id'];
      const userData = {
        userId: this.userId
      };
      this.refreshUserGroupData(userData);
    });
  }

  refreshUserGroupData(userData) {
    this.users.getAllUserGroups(userData).subscribe(data => {
      this.userGroupsInfo = data;
    });
  }

  removeUserFromGroup(user) {
    this.users.removeUserFromGroup(user).subscribe(data => {
      this.refreshUserGroupData(data);
      this.toastr.success('User removed from group!', 'Success!');
    });
  }

  addUserToGroup(group) {
    group.user_id = this.userId;
    group.group_id = group.id;
    this.users.addUserToGroup(group).subscribe(data => {
      this.refreshUserGroupData(data);
      this.toastr.success('User add to group!', 'Success!');
    }, error => this.toastr.error('User is already in this group!', 'Error!'));
  }
}
