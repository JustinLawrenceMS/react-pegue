import React, { useState } from 'react';
import axios from 'axios';
import {usePage} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";

const PegueCreate = ({ can }) => {
    const [citation, setCitation] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    const page = usePage();

    const canCreateCitations = page.auth
        && page.auth.user
        && page.auth.user.can
        && page.auth.user.can.createCitations;

    const handleClick = async () => {
        // @TODO delete true
        if (canCreateCitations || true) {
            setIsLoading(true);
            try {
                await axios.post(`/api/v1/citation`, {'citation': citation});
            } catch (e) {
                console.log('error in post', e);
            } finally {
                setIsLoading(false);
            }
        } else {
            console.error("Error creating Citation");
        }
        setCitation('');
    }

    return (
        <AuthenticatedLayout>
            <div className="min-h-screen flex items-center justify-center">
                <div className="container">
                    <div className="min-h-screen flex items-center justify-center">
                        <div id="citation-card" className="row-auto bg-gray-100 p-5 rounded-3xl">
                            <div className="row-auto">
                                <div className="md:text-9xl text-6xl dark:text-white">Add Citation</div>
                            </div>
                            <div className="row-auto">
                                <textarea
                                    className="w-full h-64 resize-none border color-gray-700 rounded-md focus:border-red-500 focus:outline-none focus:shadow-outline"
                                    id="citation"
                                    value={citation}
                                    onChange={(e) => setCitation(e.target.value)}
                                    placeholder="Enter a new citation"
                                />
                            </div>
                            <div className="row-auto">
                                <button
                                    className="px-4 py-2 pt-2 text-white dark-bg-zinc-600 bg-slate-900 rounded hover:bg-slate-500"
                                    onClick={handleClick}
                                >
                                    Add
                                </button>
                                {isLoading &&
                                    <div>
                                        <img style={{width: '3%', height: 'auto'}} src="/storage/loader.gif" alt="loading..." />
                                    </div>
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}

export default PegueCreate;
