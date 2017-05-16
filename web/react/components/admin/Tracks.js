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

export const TrackList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="name" />
            <RichTextField source="description" />
            <ReferenceField label="Branch" source="branch_id" reference="branches">
                <TextField source="name" />
            </ReferenceField>
            <EditButton basePath="/tracks" />
        </Datagrid>
    </List>
);

const TrackTitle = ({ record }) => {
    return <span>Track {record ? `"${record.name}"` : ''}</span>;
};

export const TrackEdit = (props) => (
    <Edit title={<TrackTitle />} {...props}>
        <SimpleForm>
            <DisabledInput source="id" />
            <TextInput source="name" />
            <RichTextInput source="description" />
            <ReferenceInput label="Branch" source="branch_id" reference="branches">
                <SelectInput optionText="name" />
            </ReferenceInput>
        </SimpleForm>
    </Edit>
);

export const TrackCreate = (props) => (
    <Create title="Create a Track" {...props}>
        <SimpleForm>
            <TextInput source="name" />
            <RichTextInput source="description" />
            <ReferenceInput label="Branch" source="branch_id" reference="branches" allowEmpty>
                <SelectInput optionText="name" />
            </ReferenceInput>
        </SimpleForm>
    </Create>
);
