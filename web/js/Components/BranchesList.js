/**
 * Created by salamaashoush on 5/10/17.
 */
import React, {Component} from 'react';
class BranchesList extends Component{
    constructor(props) {
        super(props);
        this.state = {name:"salama"};
    }
    render() {
        return (<h1>{this.state.name}</h1>);
    }
}
export default BranchesList;