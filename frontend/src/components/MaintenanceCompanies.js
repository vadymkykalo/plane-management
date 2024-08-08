import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './MaintenanceCompanies.css';

function MaintenanceCompanies() {
    const [companies, setCompanies] = useState([]);
    const [formData, setFormData] = useState({ name: '', contact: '', specialization: '' });
    const [editing, setEditing] = useState(false);
    const [editingId, setEditingId] = useState(null);

    useEffect(() => {
        fetchCompanies();
    }, []);

    const fetchCompanies = async () => {
        const response = await axios.get('http://localhost:8080/api/maintenance_companies');
        setCompanies(response.data);
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (editing) {
            await axios.put(`http://localhost:8080/api/maintenance_companies/${editingId}`, formData);
        } else {
            await axios.post('http://localhost:8080/api/maintenance_companies', formData);
        }
        setFormData({ name: '', contact: '', specialization: '' });
        setEditing(false);
        setEditingId(null);
        fetchCompanies();
    };

    const handleEdit = (company) => {
        setFormData(company);
        setEditing(true);
        setEditingId(company.id);
    };

    const handleDelete = async (id) => {
        await axios.delete(`http://localhost:8080/api/maintenance_companies/${id}`);
        fetchCompanies();
    };

    return (
        <div className="maintenance-companies-container">
            <h1>Maintenance Companies</h1>
            <form onSubmit={handleSubmit} className="input-group">
                <input type="text" name="name" value={formData.name} onChange={handleChange} placeholder="Name" required />
                <input type="text" name="contact" value={formData.contact} onChange={handleChange} placeholder="Contact" required />
                <input type="text" name="specialization" value={formData.specialization} onChange={handleChange} placeholder="Specialization" required />
                <button type="submit">{editing ? 'Update' : 'Create'}</button>
            </form>
            <ul className="maintenance-companies-list">
                {companies.map(company => (
                    <li key={company.id} className="maintenance-company-item">
                        <span>{company.name} - {company.contact} - {company.specialization}</span>
                        <div className="button-group">
                            <button className="edit-button" onClick={() => handleEdit(company)}>Edit</button>
                            <button className="delete-button" onClick={() => handleDelete(company.id)}>Delete</button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default MaintenanceCompanies;
