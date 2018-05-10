import { Injectable } from '@angular/core';
import { Http, Headers } from '@angular/http';
import { HttpClient } from '@angular/common/http';
import { Response } from '@angular/http';

@Injectable({
  providedIn: 'root'
})
export class GroupsService {

  constructor(private http: HttpClient) {}

  getGroups() {
      return this.http.get('http://localhost:8000/api/groups');
  }

  getUserById(id: Number) {
      return this.http.get('http://localhost:8000/api/groups/' + id);
  }

  create(group: Object) {
      return this.http.post('http://localhost:8000/api/groups', group);
  }

  delete(group: Object) {
      return this.http.post(
        'http://localhost:8000/api/deleteGroup',
        group
    );
  }

  update(group: any) {
      return this.http.put(
          'http://localhost:8000/api/groups/' + group.id,
          group
      );
  }
}
