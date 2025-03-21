export interface PageParams<T extends string = string> {
    params: {
        slug: T;
    };
}
