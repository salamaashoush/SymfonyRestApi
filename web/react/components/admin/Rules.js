/**
 * Created by salamaashoush on 5/12/17.
 */
// in posts.js
import React from 'react';
import {
    List, Datagrid, Edit, Create, SimpleForm, DateField, TextField, EditButton, DisabledInput, TextInput,
    LongTextInput, DateInput, ReferenceField, SelectInput, ReferenceInput, RichTextField,NumberInput
} from 'admin-on-rest';

export const RuleList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="absence_status" />
            <TextField source="rate" />
            <EditButton basePath="/rules" />
        </Datagrid>
    </List>
);

const BranchTitle = ({ record }) => {
    return <span>Rule {record ? `"${record.absence_status}"` : ''}</span>;
};

export const RuleEdit = (props) => (
    <Edit title={<BranchTitle />} {...props}>
        <SimpleForm>
            <DisabledInput source="id" />
            <TextInput source="absence_status" />
            <NumberInput source="rate" />
        </SimpleForm>
    </Edit>
);

export const RuleCreate = (props) => (
    <Create title="Create a Rule" {...props}>
        <SimpleForm>
            <TextInput source="absence_status" />
            <NumberInput source="rate" />
        </SimpleForm>
    </Create>
);
