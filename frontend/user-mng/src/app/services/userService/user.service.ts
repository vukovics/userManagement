import { Injectable } from '@angular/core';
import { Http, Headers } from '@angular/http';
import { HttpClient } from '@angular/common/http';
import { Response } from '@angular/http';

@Injectable()
export class UserService {
    constructor(private http: HttpClient) { }

    getUsers() {
        return this.http.get('http://localhost:8000/api/users');
    }

    addUserToGroup(user: any) {
        return this.http.post('http://localhost:8000/api/addUserToGroup', user);
    }
    removeUserFromGroup(user: any) {
        return this.http.post('http://localhost:8000/api/deleteUserFromGroup', user);
    }

    getAllUserGroups(userData: any) {
        return this.http.get('http://localhost:8000/api/usersGroups/' + userData.userId);
    }

    getUserById(id: Number) {
        return this.http.get('http://localhost:8000/api/users/' + id);
    }

    create(user: Object) {
        return this.http.post('http://localhost:8000/api/users', user);
    }

    delete(user: any) {
        return this.http.delete('http://localhost:8000/api/users/' + user.id);
    }

    update(user: any) {
        return this.http.put(
            'http://localhost:8000/api/users/' + user.id,
            user
        );
    }
}
