// app/ui/elements/Button.tsx

import clsx from 'clsx';
import * as color from "@/app/ui/theme/colors";

interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
    children: React.ReactNode;
    variant?: 'primary' | 'secondary';
    isActive?: boolean;
}

export function Button({
                           children,
                           className,
                           disabled,
                           variant = 'primary',
                           isActive = false,
                           ...rest
                       }: ButtonProps) {
    // Базовые стили для всех кнопок
    const baseStyles = "flex items-center h-10 py-2 px-4 rounded "
        + "focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 "
        + "aria-disabled:cursor-not-allowed aria-disabled:opacity-50";

    // Стили вариантов кнопок
    const variantStyles = {
        primary: `${color.BG_MEDIUM_BLUE} text-white ${color.BG_MEDIUM_BLUE_HOVER} `
            + `disabled:${color.BG_MEDIUM_BLUE} focus-visible:outline-blue-600 `
            + `${color.BG_LIGHT_BLUE_ACTIVE}`,
        secondary: "bg-gray-200 text-gray-800 hover:bg-gray-300 disabled:bg-gray-200 "
            + "focus-visible:outline-gray-600 active:bg-gray-400"
    };

    // Стили для активного состояния
    const activeStyles = {
        primary: "bg-blue-700",
        secondary: "bg-gray-300 text-gray-900"
    };

    return (
        <button
            {...rest}
            disabled={disabled}
            className={clsx(
                baseStyles,
                variantStyles[variant],
                isActive && activeStyles[variant],
                className,
            )}
        >
            {children}
        </button>
    );
}