/**
 * Created by salamaashoush on 5/10/17.
 */
import React from 'react';
import {jsonServerRestClient, fetchUtils, Admin, Resource, Delete} from 'admin-on-rest';
import {BranchList, BranchEdit, BranchCreate} from './Branches';
import {TrackList, TrackEdit, TrackCreate} from './Tracks';
import {RuleList, RuleEdit, RuleCreate} from './Rules';
import {UserList, UserEdit, UserCreate} from './Users';
import BranchesIcon from 'material-ui/svg-icons/action/book';
import TracksIcon from 'material-ui/svg-icons/action/book';
import RulesIcon from 'material-ui/svg-icons/action/book';
import UsersIcon from 'material-ui/svg-icons/action/book';
import {Card, CardHeader, CardText,CardMedia} from 'material-ui/Card';
import authClient from '../auth/authClient';


const httpClient = (url, options = {}) => {
    if (!options.headers) {
        options.headers = new Headers({Accept: 'application/json'});
    }
    const token = localStorage.getItem('token');
    options.headers.set('Authorization', `JWT ${token}`);
    return fetchUtils.fetchJson(url, options);
}
const restClient = jsonServerRestClient('http://localhost:8000/api', httpClient);

function arrayBufferToBase64(buffer) {
    var binary = '';
    var bytes = [].slice.call(new Uint8Array(buffer));

    bytes.forEach((b) => binary += String.fromCharCode(b));

    return window.btoa(binary);
};

class Dashboard extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            qrUrl: '',
        }
    }

    render() {
        return (
            <div>
                <Card style={{margin: '2em auto', width:'50%'}}>
                    <CardHeader title="Welcome to the administration"/>
                    <CardText></CardText>
                <CardMedia>
                    <img src={this.state.qrUrl} alt=""/>
                </CardMedia>

                </Card>
            </div>


        )
    }


    componentDidMount() {
        this.startCounting();
    }

    componentWillUnmount() {
        if (this._timer) {
            clearInterval(this._timer);
            this._timer = null;
        }
    }

    startCounting() {
        var self = this;
        setTimeout(function () {
            self.setState({})
            self.count(); // do it once and then start it up ...
            self._timer = setInterval(self.count.bind(self), 30000);
        }, 1000);
    }

    count() {
        this.setState({qrUrl: `http://localhost:8000/api/qrcode/${this.randomText(30)}`})
    }

    randomText(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
}
class AdminPage extends React.Component {
    render() {
        return (
            <Admin authClient={authClient} dashboard={Dashboard} restClient={restClient}>
                <Resource name="branches" list={BranchList} edit={BranchEdit} create={BranchCreate} remove={Delete}
                          icon={BranchesIcon}/>
                <Resource name="tracks" list={TrackList} edit={TrackEdit} create={TrackCreate} remove={Delete}
                          icon={TracksIcon}/>
                <Resource name="rules" list={RuleList} edit={RuleEdit} create={RuleCreate} remove={Delete}
                          icon={RulesIcon}/>
                <Resource name="users" list={UserList} edit={UserEdit} create={UserCreate} remove={Delete}
                          icon={UsersIcon}/>
            </Admin>
        );
    }
}
export default AdminPage;
