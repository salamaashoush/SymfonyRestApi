/**
 * Created by salamaashoush on 5/10/17.
 */
import React from 'react';
import {jsonServerRestClient,fetchUtils, Admin, Resource, Delete} from 'admin-on-rest';
import { BranchList, BranchEdit, BranchCreate } from './Branches';
import { TrackList, TrackEdit, TrackCreate } from './Tracks';
import { RuleList, RuleEdit, RuleCreate } from './Rules';
import { UserList, UserEdit, UserCreate } from './Users';
import BranchesIcon from 'material-ui/svg-icons/action/book';
import TracksIcon from 'material-ui/svg-icons/action/book';
import RulesIcon from 'material-ui/svg-icons/action/book';
import UsersIcon from 'material-ui/svg-icons/action/book';
import { Card, CardHeader, CardText } from 'material-ui/Card';
import authClient from '../auth/authClient';


const httpClient = (url, options = {}) => {
    if (!options.headers) {
        options.headers = new Headers({ Accept: 'application/json' });
    }
    const token = localStorage.getItem('token');
    options.headers.set('Authorization', `JWT ${token}`);
    return fetchUtils.fetchJson(url, options);
}
const restClient = jsonServerRestClient('http://localhost:8000/api', httpClient);
class Dashboard extends React.Component{
    render(){
        return(
            <Card style={{ margin: '2em' }}>
                <CardHeader title="Welcome to the administration" />
                <CardText>Lorem ipsum sic dolor amet...</CardText>
            </Card>
        )
    }
}

class AdminPage extends React.Component {
    render(){
        return(
            <Admin authClient={authClient} dashboard={Dashboard} restClient={restClient}>
                <Resource name="branches" list={BranchList} edit={BranchEdit} create={BranchCreate} remove={Delete} icon={BranchesIcon}/>
                <Resource name="tracks" list={TrackList} edit={TrackEdit} create={TrackCreate} remove={Delete} icon={TracksIcon}/>
                <Resource name="rules" list={RuleList} edit={RuleEdit} create={RuleCreate} remove={Delete} icon={RulesIcon}/>
                <Resource name="users" list={UserList} edit={UserEdit} create={UserCreate} remove={Delete} icon={UsersIcon}/>
            </Admin>
        );
    }
}
export default AdminPage;
