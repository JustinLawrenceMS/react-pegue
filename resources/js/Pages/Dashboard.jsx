import { usePage } from "@inertiajs/react";
import Cite from "citation-js";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard() {
    const { props } = usePage();

    const json = props.auth.user.jsonCitations;
    console.dir(JSON.parse('[' + json + ']'));
    const citations = props.auth.user.citations;

    let bibs = [];
    let output = [];
    for (let i = 0; i < json.length; i++) {
        output[i] = new Cite(JSON.parse(json[i]));
        bibs[i] = output[i].format('bibliography', {
            format: 'text',
            template: 'apa',
            lang: 'en-US'
        });
    }

    return (
        <AuthenticatedLayout>
            <Head title="Pegue."/>
                    <div className="md:mt-20 bg-white dark:bg-gray-900 md:ml-80 md:mr-80 flex flex-wrap rounded-2xl">
                        <a className="float-left text-9xl dark:text-white no-underline" href="/add">+</a>
                        <table className="dark:text-white">
                            <thead>
                            <th>
                                Citation
                            </th>
                            <th>
                                Descriptors
                            </th>
                            </thead>
                            <tbody>
                            {citations.map((citation, index) => (
                                <tr key={citation.id}>
                                    <td className="p-11">
                                        {bibs[index]}
                                    </td>
                                    <td className="p-11">
                                        {!citation['mesh_headings'] ? null : JSON.parse(citation['mesh_headings']).join(", ")}
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
        </AuthenticatedLayout>
);
}
