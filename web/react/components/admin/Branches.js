/**
 * Created by salamaashoush on 5/12/17.
 */
// in posts.js
import React from 'react';
import {
    List, Datagrid, Edit, Create, SimpleForm, DateField, TextField, EditButton, DisabledInput, TextInput,
    LongTextInput, DateInput, ReferenceManyField, ChipField, SingleFieldList, RichTextField
} from 'admin-on-rest';
import RichTextInput from 'aor-rich-text-input';

export const BranchList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="name" />
            <RichTextField source="description" />
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
            <RichTextInput source="description" />
            <TextInput source="location" />
            <TextInput source="address" />
            <ReferenceManyField label="Tracks" reference="tracks" target="branch_id">
                <Datagrid>
                    <TextField source="name" />
                    <RichTextField source="description" />
                    <EditButton />
                </Datagrid>
            </ReferenceManyField>
        </SimpleForm>
    </Edit>
);

export const BranchCreate = (props) => (
    <Create title="Create a Branch" {...props}>
        <SimpleForm>
            <TextInput source="name" />
            <RichTextInput source="description" />
            <TextInput source="location" />
            <TextInput source="address" />
        </SimpleForm>
    </Create>
);
