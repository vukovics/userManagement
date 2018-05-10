import { Component, OnInit, ViewContainerRef, TemplateRef } from '@angular/core';
import {GroupsService} from '../services/groupServices/groups.service';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import {NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';


@Component({
  selector: 'app-groups',
  templateUrl: './groups.component.html',
  styleUrls: ['./groups.component.css']
})
export class GroupsComponent implements OnInit {
  allGroups: any = [];
  closeResult: string;
  groupData: string;
  modalReference: any;
  groupName: string;
  isEdit: Boolean;

  constructor(public groups: GroupsService,
    private toastr: ToastrService,
    private modalService: NgbModal
  ) { }

  ngOnInit() {
    this.getGroups();
  }

  getGroups() {
    this.groups.getGroups().subscribe(data => {
        this.allGroups = data;
    });
  }

  open(content, group, isDelete) {
    if (isDelete) {
      this.deleteGroup(content, group);
    } else {
      group !== undefined ? this.editGroup(content, group) : this.createGroup(content);
    }
  }


  deleteGroup(content, group) {
    this.isEdit = false;
    this.groupName = group.group_name;
    this.modalService.open(content).result.then((result) => {
      if ( result !== 'close') {
          group.group_name = result;
          this.delete(group);
      }
    });
  }

  editGroup(content, group) {
    this.isEdit = true;
    this.groupName = group.group_name;
    this.modalService.open(content).result.then((result) => {
      if ( result !== 'close') {
          group.group_name = result;
          this.update(group);
      }
    });
  }

  createGroup(content) {
    this.isEdit = false;
    this.groupName = '';
    this.modalService.open(content).result.then((result) => {
      if ( result !== 'close') {
          this.save(result);
      }
    });
  }

  save(groupName) {
    const groupData = {
      'group_name' :  groupName
    };

    this.groups.create(groupData).subscribe(data => {
      this.getGroups();
      this.toastr.success('Group Created!', 'Success!');
    });
  }

  update(group) {
    this.groups.update(group).subscribe(data => {
      this.getGroups();
      this.toastr.success('Group Updated!', 'Success!');
    });
  }

  delete(group) {
    this.groups.delete(group).subscribe(data => {
      this.getGroups();
      this.toastr.success('Group Deleted!', 'Success!');
    }, error => this.toastr.error('Group is not empty', 'Error!'));
  }

}
