import React from "react";
import { User } from "@/app/lib/types";
import * as em from '@/app/ui/elements/EntityMetadata';
import { EntityImage } from '@/app/ui/elements/EntityImage';
import { EntityFields, TwitchAccount } from '@/app/ui/elements';

interface ProfileProps {
    user: User;
}

export function ProfileUi({ user }: ProfileProps) {

    const userFields: { label: string; value: keyof User }[] = [
        { label: "ID", value: "id" },
        { label: "Nickname", value: "nickname" },
        { label: "Email", value: "email" },
        { label: "Password", value: "password" },
        { label: "Roles", value: "roles" },
        { label: "Created at", value: "createdAt" },
        { label: "Updated at", value: "updatedAt" }
    ];

    return (
        <main className="p-9 w-2/4">
            <div className="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div className="mx-9 flex flex-col md:flex-1">

                    <em.EntityTitle
                        className={"text-4xl font-bold mb-2"}
                        title={`Welcome, ${user.nickname}!`}
                    />

                    <div className="flex flex-col md:flex-row my-9">
                        <div className="w-2/5 mr-6">
                            <EntityImage
                                id={user.id}
                                categoryName="user"
                                title="User avatar"
                                coverUrl={user.avatarUrl}
                                width="w-full"
                                height="h-[300px]"
                                imageType="avatar"
                                className="aspect-square"
                            />
                        </div>

                        <div className="flex flex-col w-3/6">
                            <EntityFields
                                entityItem={user}
                                entityFields={userFields}
                            />
                            <TwitchAccount twitchUrl={user.twitchAccount} />
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
}