/**
 * Created by salamaashoush on 5/12/17.
 */
// in posts.js
import React from 'react';
import { List, Datagrid, Edit, Create, SimpleForm, DateField, TextField, EditButton, DisabledInput, TextInput, LongTextInput, DateInput } from 'admin-on-rest';
export const BranchList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="name" />
            <TextField source="description" />
            <TextField source="location" />
            <TextField source="address" />
            <EditButton basePath="/branches" />
        </Datagrid>
    </List>
);

const BranchTitle = ({ record }) => {
    return <span>Branch {record ? `"${record.name}"` : ''}</span>;
};

export const BranchEdit = (props) => (
    <Edit title={<BranchTitle />} {...props}>
        <SimpleForm>
            <DisabledInput source="id" />
            <TextInput source="name" />
            <LongTextInput source="description" />
            <TextInput source="location" />
            <TextInput source="address" />
        </SimpleForm>
    </Edit>
);

export const BranchCreate = (props) => (
    <Create title="Create a Branch" {...props}>
        <SimpleForm>
            <TextInput source="name" />
            <LongTextInput source="description" />
            <TextInput source="location" />
            <TextInput source="address" />
        </SimpleForm>
    </Create>
);
