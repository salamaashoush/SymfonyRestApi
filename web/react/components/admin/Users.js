/**
 * Created by salamaashoush on 5/12/17.
 */
// in posts.js
import React from 'react';
import {
    List, Datagrid, Edit, Create, SimpleForm, DateField, TextField, EditButton, DisabledInput, TextInput,
    LongTextInput, DateInput, ReferenceField, SelectInput, ReferenceInput, RichTextField
} from 'admin-on-rest';
import RichTextInput from 'aor-rich-text-input';

export const UserList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="firstname" />
            <TextField source="lastname" />
            <TextField source="username" />
            <TextField source="email" />
            <ReferenceField label="Branch" source="branch_id" reference="branches">
                <TextField source="name" />
            </ReferenceField>
            <ReferenceField label="Track" source="track_id" reference="tracks">
                <TextField source="name" />
            </ReferenceField>
            <EditButton basePath="/users" />
        </Datagrid>
    </List>
);

const UserTitle = ({ record }) => {
    return <span>User {record ? `"${record.username}"` : ''}</span>;
};

export const UserEdit = (props) => (
    <Edit title={<UserTitle />} {...props}>
        <SimpleForm>
            <DisabledInput source="id" />
            <TextInput source="firstname" />
            <TextInput source="lastname" />
            <TextInput source="username" />
            <TextInput source="email" type="email"/>
            <TextInput source="plainPassword.first" value="" required type="password" label="Password"/>
            <TextInput source="plainPassword.second" value="" required type="password" label="Confirm Password"/>
            <ReferenceInput label="Branch" source="branch_id" reference="branches" allowEmpty>
                <SelectInput optionText="name" />
            </ReferenceInput>
            <ReferenceInput label="Track" source="track_id" reference="tracks" allowEmpty>
                <SelectInput optionText="name" />
            </ReferenceInput>
        </SimpleForm>
    </Edit>
);

export const UserCreate = (props) => (
    <Create title="Create a User" {...props}>
        <SimpleForm>
            <TextInput source="firstname" />
            <TextInput source="lastname" />
            <TextInput source="username" />
            <TextInput source="email" type="email"/>
            <TextInput source="plainPassword.first" type="password" label="Password"/>
            <TextInput source="plainPassword.second" type="password" label="Confirm Password"/>
            <ReferenceInput label="Branch" source="branch_id" reference="branches" allowEmpty>
                <SelectInput optionText="name" />
            </ReferenceInput>
            <ReferenceInput label="Track" source="track_id" reference="tracks" allowEmpty>
                <SelectInput optionText="name" />
            </ReferenceInput>
        </SimpleForm>
    </Create>
);
