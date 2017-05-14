/**
 * Created by salamaashoush on 5/10/17.
 */
import React from 'react';
import {jsonServerRestClient, Admin, Resource, Delete} from 'admin-on-rest';
import { BranchList, BranchEdit, BranchCreate } from './Branches';
import BranchIcon from 'material-ui/svg-icons/action/book';
import { Card, CardHeader, CardText } from 'material-ui/Card';

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
            <Admin dashboard={Dashboard} restClient={jsonServerRestClient('http://localhost:8000/api')}>
                <Resource name="branches" list={BranchList} edit={BranchEdit} create={BranchCreate} remove={Delete} icon={BranchIcon}/>
            </Admin>
        );
    }
}
export default AdminPage;
