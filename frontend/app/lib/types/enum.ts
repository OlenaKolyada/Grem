// app/lib/types/enum.ts

export enum AgeRatingEnum {
    PEGI_3 = '3+',
    PEGI_7 = '7+',
    PEGI_12 = '12+',
    PEGI_16 = '16+',
    PEGI_18 = '18+'
}

export enum CommentStatusEnum {
    Published = 'Published',
    Edited = 'Edited',
    Deleted = 'Deleted'
}

export enum PlatformRequirementsLevelEnum {
    Low = 'Low',
    Medium = 'Medium',
    High = 'High'
}

export enum StatusEnum {
    Draft = 'Draft',
    Published = 'Published',
    Archived = 'Archived',
    Deleted = 'Deleted'
}