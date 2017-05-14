import React from 'react';
import {Link, Route, Router, Switch} from 'react-router-dom';
import App from './components/App';
import AdminPage from './components/admin/AdminPage';
import HomePage from './components/home/HomePage';
import NotFoundPage from './components/errors/NotFoundPage';
import createHistory from 'history/createBrowserHistory'
const history = createHistory();

export default(
    <Router history={history}>
        <div>
            <Route exact path="/" component={HomePage}/>
            <Route path="/admin/" component={AdminPage}/>
        </div>

    </Router>
)
